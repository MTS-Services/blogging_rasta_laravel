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

class VerifyAndFixBrokenVideosJob implements ShouldQueue
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
    public $jobId;

    /**
     * Create a new job instance.
     *
     * @param int $limit
     */
    public function __construct(int $limit = 100)
    {
        $this->limit = $limit;
        $this->jobId = uniqid('verify_', true);

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
        Log::info("VerifyAndFixBrokenVideosJob started", [
            'job_id' => $this->jobId,
            'limit' => $this->limit
        ]);

        $this->updateProgress(0, 'Initializing...');

        try {
            $videos = TikTokVideo::whereNotNull('local_video_url')
                ->where('is_active', true)
                ->limit($this->limit)
                ->get();

            $total = $videos->count();

            if ($total === 0) {
                Log::info("No videos to verify", ['job_id' => $this->jobId]);
                $this->updateProgress(100, 'No videos to verify', true);
                return;
            }

            $brokenCount = 0;
            $fixedCount = 0;
            $clearedCount = 0;
            $details = [];

            foreach ($videos as $index => $video) {
                try {
                    // Update progress
                    $progress = (int) ((($index + 1) / $total) * 100);
                    $this->updateProgress(
                        $progress,
                        "Verifying {$video->aweme_id} " . ($index + 1) / $total . " )......."
                    );

                    Log::debug("Verifying video", [
                        'job_id' => $this->jobId,
                        'aweme_id' => $video->aweme_id,
                        'local_url' => $video->local_video_url
                    ]);

                    // Check if local video exists
                    if (!$videoService->videoExists($video->local_video_url)) {
                        $brokenCount++;

                        Log::warning("Broken local video found", [
                            'job_id' => $this->jobId,
                            'aweme_id' => $video->aweme_id,
                            'local_url' => $video->local_video_url
                        ]);

                        // Try to redownload
                        if (!empty($video->play_url)) {
                            $newLocalUrl = $videoService->downloadWithRetry(
                                $video->play_url,
                                $video->aweme_id,
                                $video->username,
                                2 // max retries
                            );

                            if ($newLocalUrl) {
                                $video->update([
                                    'local_video_url' => $newLocalUrl,
                                    'sync_at' => now()
                                ]);
                                $fixedCount++;

                                $details[] = [
                                    'aweme_id' => $video->aweme_id,
                                    'username' => $video->username,
                                    'action' => 'fixed',
                                    'old_url' => $video->local_video_url,
                                    'new_url' => $newLocalUrl
                                ];

                                Log::info("Fixed broken video", [
                                    'job_id' => $this->jobId,
                                    'aweme_id' => $video->aweme_id,
                                    'new_url' => $newLocalUrl
                                ]);
                            } else {
                                // Mark as needing attention
                                $video->update(['local_video_url' => null]);
                                $clearedCount++;

                                $details[] = [
                                    'aweme_id' => $video->aweme_id,
                                    'username' => $video->username,
                                    'action' => 'cleared',
                                    'reason' => 'Could not redownload'
                                ];

                                Log::warning("Could not fix broken video, cleared URL", [
                                    'job_id' => $this->jobId,
                                    'aweme_id' => $video->aweme_id
                                ]);
                            }
                        } else {
                            // No CDN URL, clear local_video_url
                            $video->update(['local_video_url' => null]);
                            $clearedCount++;

                            $details[] = [
                                'aweme_id' => $video->aweme_id,
                                'username' => $video->username,
                                'action' => 'cleared',
                                'reason' => 'No CDN URL available'
                            ];

                            Log::warning("Cleared broken video URL (no CDN URL)", [
                                'job_id' => $this->jobId,
                                'aweme_id' => $video->aweme_id
                            ]);
                        }
                    } else {
                        $details[] = [
                            'aweme_id' => $video->aweme_id,
                            'username' => $video->username,
                            'action' => 'valid',
                            'reason' => 'Video file exists'
                        ];
                    }

                    // Small delay
                    usleep(100000); // 0.1 seconds

                } catch (\Exception $e) {
                    Log::error("Error verifying video", [
                        'job_id' => $this->jobId,
                        'aweme_id' => $video->aweme_id ?? 'unknown',
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);

                    $details[] = [
                        'aweme_id' => $video->aweme_id ?? 'unknown',
                        'username' => $video->username ?? 'unknown',
                        'action' => 'error',
                        'reason' => $e->getMessage()
                    ];
                }
            }

            $result = [
                'total' => $total,
                'broken_count' => $brokenCount,
                'fixed_count' => $fixedCount,
                'cleared_count' => $clearedCount,
                'valid_count' => $total - $brokenCount,
                'details' => $details
            ];

            $message = "Checked {$total} videos: {$brokenCount} broken, {$fixedCount} fixed, {$clearedCount} cleared";

            $this->updateProgress(100, $message, true, $result);

            Log::info("VerifyAndFixBrokenVideosJob completed", [
                'job_id' => $this->jobId,
                'result' => $result
            ]);

        } catch (\Exception $e) {
            Log::error("VerifyAndFixBrokenVideosJob failed", [
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
        $cacheKey = "job_progress:verify:{$this->jobId}";

        Cache::put($cacheKey, [
            'job_id' => $this->jobId,
            'type' => 'verify',
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
        Log::error("VerifyAndFixBrokenVideosJob failed permanently", [
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
        return ['video-management', 'verify', $this->jobId];
    }
}
