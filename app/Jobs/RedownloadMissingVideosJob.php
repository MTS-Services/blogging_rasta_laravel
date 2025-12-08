<?php

namespace App\Jobs;

use App\Models\TikTokVideo;
use App\Services\VideoDownloadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RedownloadMissingVideosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600; // 1 hour

    /**
     * Job parameters
     */
    protected $limit;
    protected $force;
    public $jobId;

    /**
     * Create a new job instance.
     *
     * @param int $limit
     * @param bool $force
     */
    public function __construct(int $limit = 50, bool $force = false)
    {
        $this->limit = $limit;
        $this->force = $force;
        $this->jobId = uniqid('redownload_', true);

        // $this->onQueue('video-processing');
    }

    /**
     * Execute the job.
     *
     * @param VideoDownloadService $videoService
     * @return void
     */
    public function handle(VideoDownloadService $videoService)
    {
        Log::info("RedownloadMissingVideosJob started", [
            'job_id' => $this->jobId,
            'limit' => $this->limit,
            'force' => $this->force
        ]);

        $this->updateProgress(0, 'Initializing...');

        try {
            // Build query
            $query = TikTokVideo::query();

            if ($this->force) {
                $videos = $query->whereNotNull('play_url')
                    ->where('is_active', true)
                    ->orderBy('created_at', 'desc')
                    ->limit($this->limit)
                    ->get();
            } else {
                $videos = $query->whereNull('local_video_url')
                    ->whereNotNull('play_url')
                    ->where('is_active', true)
                    ->orderBy('created_at', 'desc')
                    ->limit($this->limit)
                    ->get();
            }

            $total = $videos->count();

            if ($total === 0) {
                Log::info("No videos to redownload", ['job_id' => $this->jobId]);
                $this->updateProgress(100, 'No videos need redownloading', true);
                return;
            }

            $successCount = 0;
            $failedCount = 0;
            $skippedCount = 0;
            $details = [];

            foreach ($videos as $index => $video) {
                try {
                    // Update progress
                    $progress = 0;
                    if (isset($index) && isset($total)) {
                        $progress = (int) ((($index + 1) / $total) * 100);
                    }
                    $this->updateProgress(
                        $progress,
                        "Processing " . $video->aweme_id . " (" . ($index + 1) / $total . ")..."
                    );

                    // Skip if no play_url
                    if (empty($video->play_url)) {
                        $skippedCount++;
                        $details[] = [
                            'aweme_id' => $video->aweme_id,
                            'username' => $video->username,
                            'status' => 'skipped',
                            'reason' => 'No play URL available'
                        ];

                        Log::warning("Skipped video - no play URL", [
                            'job_id' => $this->jobId,
                            'aweme_id' => $video->aweme_id
                        ]);
                        continue;
                    }

                    Log::info("Processing video for redownload", [
                        'job_id' => $this->jobId,
                        'aweme_id' => $video->aweme_id,
                        'username' => $video->username,
                        'progress' => ($index + 1) / $total
                    ]);

                    // Download video with retry
                    $localUrl = $videoService->downloadWithRetry(
                        $video->play_url,
                        $video->aweme_id,
                        $video->username,
                        3 // max retries
                    );

                    if ($localUrl) {
                        // Update database
                        $video->update([
                            'local_video_url' => $localUrl,
                            'sync_at' => now()
                        ]);

                        $successCount++;
                        $details[] = [
                            'aweme_id' => $video->aweme_id,
                            'username' => $video->username,
                            'status' => 'success',
                            'local_url' => $localUrl
                        ];

                        Log::info("Video redownloaded successfully", [
                            'job_id' => $this->jobId,
                            'aweme_id' => $video->aweme_id,
                            'local_url' => $localUrl
                        ]);
                    } else {
                        $failedCount++;
                        $details[] = [
                            'aweme_id' => $video->aweme_id,
                            'username' => $video->username,
                            'status' => 'failed',
                            'reason' => 'Download failed after retries'
                        ];

                        Log::error("Failed to redownload video", [
                            'job_id' => $this->jobId,
                            'aweme_id' => $video->aweme_id
                        ]);
                    }

                    // Small delay to avoid overwhelming the server
                    usleep(500000); // 0.5 seconds

                } catch (\Exception $e) {
                    $failedCount++;
                    $details[] = [
                        'aweme_id' => $video->aweme_id ?? 'unknown',
                        'username' => $video->username ?? 'unknown',
                        'status' => 'error',
                        'reason' => $e->getMessage()
                    ];

                    Log::error("Exception during video redownload", [
                        'job_id' => $this->jobId,
                        'aweme_id' => $video->aweme_id ?? 'unknown',
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $result = [
                'total' => $total,
                'success_count' => $successCount,
                'failed_count' => $failedCount,
                'skipped_count' => $skippedCount,
                'details' => $details
            ];

            $message = "Processed {$total} videos: {$successCount} successful, {$failedCount} failed, {$skippedCount} skipped";

            $this->updateProgress(100, $message, true, $result);

            Log::info("RedownloadMissingVideosJob completed", [
                'job_id' => $this->jobId,
                'result' => $result
            ]);

        } catch (\Exception $e) {
            Log::error("RedownloadMissingVideosJob failed", [
                'job_id' => $this->jobId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->updateProgress(100, 'Job failed: ' . $e->getMessage(), true, [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Update job progress in cache
     *
     * @param int $progress
     * @param string $message
     * @param bool $completed
     * @param array $data
     */
    protected function updateProgress(int $progress, string $message, bool $completed = false, array $data = [])
    {
        $cacheKey = "job_progress:redownload:{$this->jobId}";

        Cache::put($cacheKey, [
            'job_id' => $this->jobId,
            'type' => 'redownload',
            'progress' => $progress,
            'message' => $message,
            'completed' => $completed,
            'data' => $data,
            'updated_at' => now()->toDateTimeString()
        ], now()->addHours(24));
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error("RedownloadMissingVideosJob failed permanently", [
            'job_id' => $this->jobId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);

        $this->updateProgress(100, 'Job failed: ' . $exception->getMessage(), true, [
            'error' => $exception->getMessage()
        ]);
    }

    /**
     * Get unique tags for the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['video-management', 'redownload', $this->jobId];
    }
}
