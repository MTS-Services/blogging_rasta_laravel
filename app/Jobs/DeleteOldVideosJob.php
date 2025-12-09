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

class DeleteOldVideosJob implements ShouldQueue
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
    protected $olderThanDays;
    protected $limit;
    public $jobId;

    /**
     * Create a new job instance.
     *
     * @param int $olderThanDays
     * @param int $limit
     */
    public function __construct(int $olderThanDays = 90, int $limit = 100)
    {
        $this->olderThanDays = $olderThanDays;
        $this->limit = $limit;
        $this->jobId = uniqid('delete_', true);

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
        Log::info("DeleteOldVideosJob started", [
            'job_id' => $this->jobId,
            'older_than_days' => $this->olderThanDays,
            'limit' => $this->limit
        ]);

        $this->updateProgress(0, 'Initializing...');

        try {
            $videos = TikTokVideo::where('created_at', '<', now()->subDays($this->olderThanDays))
                ->whereNotNull('local_video_url')
                ->where('is_active', false)
                ->limit($this->limit)
                ->get();

            $total = $videos->count();

            if ($total === 0) {
                Log::info("No old videos to delete", ['job_id' => $this->jobId]);
                $this->updateProgress(100, 'No old videos to delete', true);
                return;
            }

            $deletedCount = 0;
            $failedCount = 0;
            $freedSpaceBytes = 0;
            $details = [];

            foreach ($videos as $index => $video) {
                try {
                    // Update progress
                    $progress = (int) ((($index + 1) / $total) * 100);
                    $this->updateProgress(
                        $progress,
                        "Deleting " . ($video->video_id) . " (" . ($index + 1) / $total . ")......."
                    );

                    Log::info("Processing video for deletion", [
                        'job_id' => $this->jobId,
                        'video_id' => $video->video_id,
                        'username' => $video->username,
                        'local_url' => $video->local_video_url,
                        'created_at' => $video->created_at
                    ]);

                    // Get file size before deleting
                    $size = $videoService->getVideoSize($video->local_video_url);

                    // Delete local file
                    if ($videoService->deleteVideo($video->local_video_url)) {
                        // Update database to clear local_video_url
                        $video->update(['local_video_url' => null]);

                        $deletedCount++;

                        if ($size) {
                            $freedSpaceBytes += $size;
                        }

                        $details[] = [
                            'video_id' => $video->video_id,
                            'username' => $video->username,
                            'status' => 'deleted',
                            'size_mb' => $size ? round($size / (1024 * 1024), 2) : null,
                            'age_days' => now()->diffInDays($video->created_at)
                        ];

                        Log::info("Video file deleted successfully", [
                            'job_id' => $this->jobId,
                            'video_id' => $video->video_id,
                            'size_mb' => $size ? round($size / (1024 * 1024), 2) : 0
                        ]);
                    } else {
                        $failedCount++;

                        $details[] = [
                            'video_id' => $video->video_id,
                            'username' => $video->username,
                            'status' => 'failed',
                            'reason' => 'Could not delete file'
                        ];

                        Log::error("Failed to delete video file", [
                            'job_id' => $this->jobId,
                            'video_id' => $video->video_id,
                            'local_url' => $video->local_video_url
                        ]);
                    }

                    // Small delay
                    usleep(100000); // 0.1 seconds

                } catch (\Exception $e) {
                    $failedCount++;

                    $details[] = [
                        'video_id' => $video->video_id ?? 'unknown',
                        'username' => $video->username ?? 'unknown',
                        'status' => 'error',
                        'reason' => $e->getMessage()
                    ];

                    Log::error("Exception during video deletion", [
                        'job_id' => $this->jobId,
                        'video_id' => $video->video_id ?? 'unknown',
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }

            $freedSpaceMB = round($freedSpaceBytes / (1024 * 1024), 2);

            $result = [
                'total' => $total,
                'deleted_count' => $deletedCount,
                'failed_count' => $failedCount,
                'freed_space_mb' => $freedSpaceMB,
                'freed_space_gb' => round($freedSpaceMB / 1024, 2),
                'details' => $details
            ];

            $message = "Deleted {$deletedCount} old videos (freed {$freedSpaceMB} MB), {$failedCount} failed";

            $this->updateProgress(100, $message, true, $result);

            Log::info("DeleteOldVideosJob completed", [
                'job_id' => $this->jobId,
                'result' => $result
            ]);

        } catch (\Exception $e) {
            Log::error("DeleteOldVideosJob failed", [
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
        $cacheKey = "job_progress:delete:{$this->jobId}";

        Cache::put($cacheKey, [
            'job_id' => $this->jobId,
            'type' => 'delete',
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
        Log::error("DeleteOldVideosJob failed permanently", [
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
        return ['video-management', 'delete', $this->jobId];
    }
}
