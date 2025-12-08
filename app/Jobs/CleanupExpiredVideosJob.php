<?php

namespace App\Jobs;

use App\Models\TikTokVideo;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CleanupExpiredVideosJob implements ShouldQueue
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
    protected $deleteInactive;
    public $jobId;
    protected $client;

    /**
     * Create a new job instance.
     *
     * @param int $olderThanDays
     * @param bool $deleteInactive
     */
    public function __construct(int $olderThanDays = 7, bool $deleteInactive = false)
    {
        $this->olderThanDays = $olderThanDays;
        $this->deleteInactive = $deleteInactive;
        $this->jobId = uniqid('cleanup_', true);

        // $this->onQueue('video-processing');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("CleanupExpiredVideosJob started", [
            'job_id' => $this->jobId,
            'older_than_days' => $this->olderThanDays,
            'delete_inactive' => $this->deleteInactive
        ]);

        $this->updateProgress(0, 'Initializing...');

        // Initialize HTTP client
        $this->client = new Client([
            'timeout' => 5,
            'connect_timeout' => 3,
            'http_errors' => false
        ]);

        try {
            // Find videos that need cleanup
            $query = TikTokVideo::whereNull('local_video_url')
                ->where('created_at', '<', now()->subDays($this->olderThanDays));

            if ($this->deleteInactive) {
                $query->where('is_active', false);
            }

            $videos = $query->get();
            $total = $videos->count();

            if ($total === 0) {
                Log::info("No expired videos found", ['job_id' => $this->jobId]);
                $this->updateProgress(100, 'No expired videos found', true);
                return;
            }

            $checkedCount = 0;
            $expiredCount = 0;
            $deactivatedCount = 0;
            $deletedCount = 0;
            $details = [];

            foreach ($videos as $index => $video) {
                try {
                    // Update progress
                    $progress = (int) ((($index + 1) / $total) * 100);
                    $this->updateProgress(
                        $progress,
                        "Checking {$video->aweme_id} " . ($index + 1) / $total . ").........."
                    );

                    $checkedCount++;

                    // Check if CDN URL is still valid
                    $isExpired = $this->checkIfUrlExpired($video->play_url);

                    if ($isExpired) {
                        $expiredCount++;

                        if ($this->deleteInactive && $video->is_active == false) {
                            // Delete the video completely
                            $video->delete();
                            $deletedCount++;

                            $details[] = [
                                'aweme_id' => $video->aweme_id,
                                'username' => $video->username,
                                'action' => 'deleted',
                                'reason' => 'Expired CDN URL and inactive'
                            ];

                            Log::info("Deleted expired video", [
                                'job_id' => $this->jobId,
                                'aweme_id' => $video->aweme_id
                            ]);
                        } else {
                            // Just deactivate
                            $video->update(['is_active' => false]);
                            $deactivatedCount++;

                            $details[] = [
                                'aweme_id' => $video->aweme_id,
                                'username' => $video->username,
                                'action' => 'deactivated',
                                'reason' => 'Expired CDN URL'
                            ];

                            Log::info("Deactivated expired video", [
                                'job_id' => $this->jobId,
                                'aweme_id' => $video->aweme_id
                            ]);
                        }
                    } else {
                        $details[] = [
                            'aweme_id' => $video->aweme_id,
                            'username' => $video->username,
                            'action' => 'valid',
                            'reason' => 'CDN URL still accessible'
                        ];
                    }

                    // Small delay
                    usleep(200000); // 0.2 seconds

                } catch (\Exception $e) {
                    Log::error("Error checking video expiration", [
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
                'checked_count' => $checkedCount,
                'expired_count' => $expiredCount,
                'deactivated_count' => $deactivatedCount,
                'deleted_count' => $deletedCount,
                'details' => $details
            ];

            $message = "Checked {$checkedCount} videos: {$expiredCount} expired, {$deactivatedCount} deactivated, {$deletedCount} deleted";

            $this->updateProgress(100, $message, true, $result);

            Log::info("CleanupExpiredVideosJob completed", [
                'job_id' => $this->jobId,
                'result' => $result
            ]);

        } catch (\Exception $e) {
            Log::error("CleanupExpiredVideosJob failed", [
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
     * Check if a URL is expired (returns 410 Gone or other error)
     *
     * @param string $url
     * @return bool
     */
    protected function checkIfUrlExpired($url)
    {
        if (empty($url)) {
            return true;
        }

        try {
            // Make HEAD request to check if URL is accessible
            $response = $this->client->head($url);
            $statusCode = $response->getStatusCode();

            // 410 Gone = expired
            // 403 Forbidden = expired/blocked
            // 404 Not Found = expired
            if (in_array($statusCode, [410, 403, 404])) {
                Log::info("URL expired", [
                    'job_id' => $this->jobId,
                    'url' => substr($url, 0, 100),
                    'status_code' => $statusCode
                ]);
                return true;
            }

            // 200 OK = still valid
            if ($statusCode === 200) {
                return false;
            }

            // Other status codes, consider expired to be safe
            return true;

        } catch (\Exception $e) {
            // If we can't check, assume expired
            Log::warning("Could not check URL expiration", [
                'job_id' => $this->jobId,
                'url' => substr($url, 0, 100),
                'error' => $e->getMessage()
            ]);
            return true;
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
        $cacheKey = "job_progress:cleanup:{$this->jobId}";

        Cache::put($cacheKey, [
            'job_id' => $this->jobId,
            'type' => 'cleanup',
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
        Log::error("CleanupExpiredVideosJob failed permanently", [
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
        return ['video-management', 'cleanup', $this->jobId];
    }
}
