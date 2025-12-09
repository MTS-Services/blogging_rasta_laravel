<?php

namespace App\Services;

use App\Models\TikTokVideo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class VideoManagementService
{
    protected $videoService;
    protected $tiktokService;
    protected $client;

    public function __construct(
        VideoDownloadService $videoService,
        TikTokService $tiktokService
    ) {
        $this->videoService = $videoService;
        $this->tiktokService = $tiktokService;

        $this->client = new Client([
            'timeout' => 5,
            'connect_timeout' => 3,
            'http_errors' => false
        ]);
    }

    /**
     * Redownload missing videos
     *
     * @param int $limit Number of videos to process
     * @param bool $force Force redownload even if local exists
     * @return array
     */
    public function redownloadMissingVideos($limit = 50, $force = false)
    {
        Log::info("Starting redownload missing videos", [
            'limit' => $limit,
            'force' => $force
        ]);

        try {
            // Build query
            $query = TikTokVideo::query();

            if ($force) {
                $videos = $query->whereNotNull('play_url')
                    ->where('is_active', true) // Use where instead of active() scope
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            } else {
                $videos = $query->whereNull('local_video_url')
                    ->whereNotNull('play_url')
                    ->where('is_active', true) // Use where instead of active() scope
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
            }

            $total = $videos->count();

            if ($total === 0) {
                return [
                    'success' => true,
                    'message' => 'No videos need redownloading',
                    'total' => 0,
                    'success_count' => 0,
                    'failed_count' => 0,
                    'skipped_count' => 0,
                    'details' => []
                ];
            }

            $successCount = 0;
            $failedCount = 0;
            $skippedCount = 0;
            $details = [];

            foreach ($videos as $video) {
                try {
                    // Skip if no play_url
                    if (empty($video->play_url)) {
                        $skippedCount++;
                        $details[] = [

                            'video_id' => $video->video_id,
                            'username' => $video->username,
                            'status' => 'skipped',
                            'reason' => 'No play URL available'
                        ];
                        continue;
                    }

                    Log::info("Processing video for redownload", [

                        'video_id' => $video->video_id,
                        'username' => $video->username
                    ]);

                    // Download video with retry
                    $localUrl = $this->videoService->downloadAndStore(
                        $video->play_url,
                        $video->video_id,
                        $video->username,
                    );

                    if ($localUrl) {
                        // Update database
                        $video->update([
                            'local_video_url' => $localUrl,
                            'sync_at' => now()
                        ]);

                        $successCount++;
                        $details[] = [

                            'video_id' => $video->video_id,
                            'username' => $video->username,
                            'status' => 'success',
                            'local_url' => $localUrl
                        ];

                        Log::info("Video redownloaded successfully", [

                            'video_id' => $video->video_id,
                        ]);
                    } else {
                        $failedCount++;
                        $details[] = [

                            'video_id' => $video->video_id,
                            'username' => $video->username,
                            'status' => 'failed',
                            'reason' => 'Download failed after retries'
                        ];

                        Log::error("Failed to redownload video", [

                            'video_id' => $video->video_id,
                        ]);
                    }

                    // Small delay to avoid overwhelming the server
                    usleep(500000); // 0.5 seconds

                } catch (\Exception $e) {
                    $failedCount++;
                    $details[] = [

                        'video_id' => $video->video_id,
                        'username' => $video->username,
                        'status' => 'error',
                        'reason' => $e->getMessage()
                    ];

                    Log::error("Exception during video redownload", [

                        'video_id' => $video->video_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $result = [
                'success' => true,
                'message' => "Processed {$total} videos: {$successCount} successful, {$failedCount} failed, {$skippedCount} skipped",
                'total' => $total,
                'success_count' => $successCount,
                'failed_count' => $failedCount,
                'skipped_count' => $skippedCount,
                'details' => $details
            ];

            Log::info("Redownload process completed", $result);

            return $result;

        } catch (\Exception $e) {
            Log::error("Redownload missing videos failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to redownload videos: ' . $e->getMessage(),
                'total' => 0,
                'success_count' => 0,
                'failed_count' => 0,
                'skipped_count' => 0,
                'details' => []
            ];
        }
    }

    /**
     * Cleanup expired videos (videos with expired CDN URLs)
     *
     * @param int $olderThanDays Videos older than X days
     * @param bool $deleteInactive Also delete inactive videos
     * @return array
     */
    public function cleanupExpiredVideos($olderThanDays = 7, $deleteInactive = false)
    {
        Log::info("Starting cleanup expired videos", [
            'older_than_days' => $olderThanDays,
            'delete_inactive' => $deleteInactive
        ]);

        try {
            // Find videos that need cleanup
            $query = TikTokVideo::whereNull('local_video_url')
                ->where('created_at', '<', now()->subDays($olderThanDays));

            if ($deleteInactive) {
                $query->inactive();
            }

            $videos = $query->get();
            $total = $videos->count();

            if ($total === 0) {
                return [
                    'success' => true,
                    'message' => 'No expired videos found',
                    'total' => 0,
                    'checked_count' => 0,
                    'expired_count' => 0,
                    'deactivated_count' => 0,
                    'deleted_count' => 0,
                    'details' => []
                ];
            }

            $checkedCount = 0;
            $expiredCount = 0;
            $deactivatedCount = 0;
            $deletedCount = 0;
            $details = [];

            foreach ($videos as $video) {
                try {
                    $checkedCount++;

                    // Check if CDN URL is still valid
                    $isExpired = $this->checkIfUrlExpired($video->play_url);

                    if ($isExpired) {
                        $expiredCount++;

                        if ($deleteInactive && $video->is_active == false) {
                            // Delete the video completely
                            $video->delete();
                            $deletedCount++;

                            $details[] = [

                                'video_id' => $video->video_id,
                                'username' => $video->username,
                                'action' => 'deleted',
                                'reason' => 'Expired CDN URL and inactive'
                            ];

                            Log::info("Deleted expired video", [

                                'video_id' => $video->video_id,
                            ]);
                        } else {
                            // Just deactivate
                            $video->update(['is_active' => false]);
                            $deactivatedCount++;

                            $details[] = [

                                'video_id' => $video->video_id,
                                'username' => $video->username,
                                'action' => 'deactivated',
                                'reason' => 'Expired CDN URL'
                            ];

                            Log::info("Deactivated expired video", [

                                'video_id' => $video->video_id,
                            ]);
                        }
                    } else {
                        $details[] = [

                            'video_id' => $video->video_id,
                            'username' => $video->username,
                            'action' => 'valid',
                            'reason' => 'CDN URL still accessible'
                        ];
                    }

                    // Small delay
                    usleep(200000); // 0.2 seconds

                } catch (\Exception $e) {
                    Log::error("Error checking video expiration", [

                        'video_id' => $video->video_id,
                        'error' => $e->getMessage()
                    ]);

                    $details[] = [

                        'video_id' => $video->video_id,
                        'username' => $video->username,
                        'action' => 'error',
                        'reason' => $e->getMessage()
                    ];
                }
            }

            $result = [
                'success' => true,
                'message' => "Checked {$checkedCount} videos: {$expiredCount} expired, {$deactivatedCount} deactivated, {$deletedCount} deleted",
                'total' => $total,
                'checked_count' => $checkedCount,
                'expired_count' => $expiredCount,
                'deactivated_count' => $deactivatedCount,
                'deleted_count' => $deletedCount,
                'details' => $details
            ];

            Log::info("Cleanup process completed", $result);

            return $result;

        } catch (\Exception $e) {
            Log::error("Cleanup expired videos failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to cleanup videos: ' . $e->getMessage(),
                'total' => 0,
                'checked_count' => 0,
                'expired_count' => 0,
                'deactivated_count' => 0,
                'deleted_count' => 0,
                'details' => []
            ];
        }
    }

    /**
     * Check if a URL is expired (returns 410 Gone or other error)
     *
     * @param string $url
     * @return bool
     */
    private function checkIfUrlExpired($url)
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
                'url' => substr($url, 0, 100),
                'error' => $e->getMessage()
            ]);
            return true;
        }
    }

    /**
     * Get statistics about video storage
     *
     * @return array
     */
    public function getStorageStatistics()
    {
        try {
            $stats = [
                'total_videos' => TikTokVideo::count(),
                'with_local_storage' => TikTokVideo::whereNotNull('local_video_url')->count(),
                'without_local_storage' => TikTokVideo::whereNull('local_video_url')->count(),
                'active_videos' => TikTokVideo::active()->count(),
                'inactive_videos' => TikTokVideo::inactive()->count(),
                'old_videos_without_storage' => TikTokVideo::whereNull('local_video_url')
                    ->where('created_at', '<', now()->subDays(7))
                    ->count(),
            ];

            // Calculate percentages
            $stats['storage_percentage'] = $stats['total_videos'] > 0
                ? round(($stats['with_local_storage'] / $stats['total_videos']) * 100, 2)
                : 0;

            // Get storage size if possible
            try {
                $storageSize = $this->getStorageSize();
                $stats['storage_size_mb'] = $storageSize;
            } catch (\Exception $e) {
                $stats['storage_size_mb'] = null;
            }

            return [
                'success' => true,
                'statistics' => $stats
            ];

        } catch (\Exception $e) {
            Log::error("Failed to get storage statistics", [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get total storage size in MB
     *
     * @return float
     */
    private function getStorageSize()
    {
        $path = storage_path('app/public/videos/tiktok');

        if (!is_dir($path)) {
            return 0;
        }

        $size = 0;
        $files = glob($path . '/*');

        foreach ($files as $file) {
            if (is_file($file)) {
                $size += filesize($file);
            }
        }

        // Convert to MB
        return round($size / (1024 * 1024), 2);
    }

    /**
     * Delete old videos to free up space
     *
     * @param int $olderThanDays Videos older than X days
     * @param int $limit Max number to delete
     * @return array
     */
    public function deleteOldVideos($olderThanDays = 90, $limit = 100)
    {
        Log::info("Starting delete old videos", [
            'older_than_days' => $olderThanDays,
            'limit' => $limit
        ]);

        try {
            $videos = TikTokVideo::where('created_at', '<', now()->subDays($olderThanDays))
                ->whereNotNull('local_video_url')
                ->inactive()
                ->limit($limit)
                ->get();

            $total = $videos->count();
            $deletedCount = 0;
            $freedSpaceMB = 0;

            foreach ($videos as $video) {
                try {
                    // Get file size before deleting
                    $size = $this->videoService->getVideoSize($video->local_video_url);

                    // Delete local file
                    if ($this->videoService->deleteVideo($video->local_video_url)) {
                        $video->update(['local_video_url' => null]);
                        $deletedCount++;

                        if ($size) {
                            $freedSpaceMB += ($size / (1024 * 1024));
                        }
                    }

                } catch (\Exception $e) {
                    Log::error("Failed to delete old video", [

                        'video_id' => $video->video_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return [
                'success' => true,
                'message' => "Deleted {$deletedCount} old videos, freed " . round($freedSpaceMB, 2) . " MB",
                'total' => $total,
                'deleted_count' => $deletedCount,
                'freed_space_mb' => round($freedSpaceMB, 2)
            ];

        } catch (\Exception $e) {
            Log::error("Delete old videos failed", [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to delete old videos: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify and fix broken local video URLs
     *
     * @param int $limit
     * @return array
     */
    public function verifyAndFixBrokenVideos($limit = 100)
    {
        Log::info("Starting verify and fix broken videos", ['limit' => $limit]);

        try {
            $videos = TikTokVideo::whereNotNull('local_video_url')
                ->active()
                ->limit($limit)
                ->get();

            $total = $videos->count();
            $brokenCount = 0;
            $fixedCount = 0;

            foreach ($videos as $video) {
                try {
                    // Check if local video exists
                    if (!$this->videoService->videoExists($video->local_video_url)) {
                        $brokenCount++;

                        Log::warning("Broken local video found", [

                            'video_id' => $video->video_id,
                            'local_url' => $video->local_video_url
                        ]);

                        // Try to redownload
                        if (!empty($video->play_url)) {
                            $newLocalUrl = $this->videoService->downloadAndStore(
                                $video->play_url,
                                $video->video_id,
                                $video->username,
                            );

                            if ($newLocalUrl) {
                                $video->update(['local_video_url' => $newLocalUrl]);
                                $fixedCount++;

                                Log::info("Fixed broken video", [

                                    'video_id' => $video->video_id,
                                ]);
                            } else {
                                // Mark as needing attention
                                $video->update(['local_video_url' => null]);
                            }
                        } else {
                            // No CDN URL, clear local_video_url
                            $video->update(['local_video_url' => null]);
                        }
                    }

                } catch (\Exception $e) {
                    Log::error("Error verifying video", [

                        'video_id' => $video->video_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return [
                'success' => true,
                'message' => "Checked {$total} videos: {$brokenCount} broken, {$fixedCount} fixed",
                'total' => $total,
                'broken_count' => $brokenCount,
                'fixed_count' => $fixedCount
            ];

        } catch (\Exception $e) {
            Log::error("Verify and fix broken videos failed", [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to verify videos: ' . $e->getMessage()
            ];
        }
    }
}
