<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class VideoDownloadService
{
    protected $client;
    /** @var string Primary disk for new uploads: 's3'. Legacy/local is 'public'. */
    protected $disk = 'public';
    protected $videoPath = 'videos/tiktok';

    /** Whether to store new videos on S3 (true) or only on local (false). */
    protected bool $useS3ForStorage = true;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 600,
            'connect_timeout' => 60,
            'read_timeout' => 600,
            'verify' => false,
            'http_errors' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'video/mp4,video/*,*/*',
                'Accept-Encoding' => 'identity',
                'Connection' => 'keep-alive',
            ],
            'curl' => [
                CURLOPT_TCP_KEEPALIVE => 1,
                CURLOPT_TCP_KEEPIDLE => 120,
                CURLOPT_TCP_KEEPINTVL => 60,
            ]
        ]);

        // Ensure local directory exists for legacy/fallback (commented: was required for local-only store)
        $fullDirPath = storage_path("app/public/{$this->videoPath}");
        if (!file_exists($fullDirPath)) {
            mkdir($fullDirPath, 0755, true);
        }
    }

    /**
     * Normalize path: from full URL or path to relative storage path (e.g. videos/tiktok/file.mp4).
     */
    protected function normalizeStoragePath(string $urlOrPath): string
    {
        $path = $urlOrPath;
        $path = str_replace([
            Storage::disk('public')->url(''),
            url('storage/'),
            url('/storage/'),
        ], '', $path);
        return ltrim($path, '/');
    }

    /**
     * Check if video exists on S3 (primary) or local (legacy).
     */
    protected function existsOnS3(string $storagePath): bool
    {
        try {
            return config('filesystems.disks.s3.bucket') && Storage::disk('s3')->exists($storagePath);
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Download and store video - Returns storage path for database (same path format for SEO URL).
     * New videos are stored on S3; existing local logic is commented for reference.
     *
     * @param string $videoUrl
     * @param string $videoId
     * @param string $username
     * @return string|null Returns relative path like "videos/tiktok/username_id_timestamp.mp4" or null on failure
     */
    public function downloadAndStore($videoUrl, $videoId, $username = 'creator')
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        if (empty($videoUrl)) {
            Log::warning('Empty video URL', ['video_id' => $videoId]);
            return null;
        }

        $filename = $this->generateFilename($videoId, $username);
        $storagePath = "{$this->videoPath}/{$filename}"; // Same path for DB and URL (SEO)

        // Temp file in system temp (not inside public storage)
        $tempPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'tiktok_' . $filename . '.tmp';

        try {
            // Check if already exists: S3 first, then local (legacy)
            if ($this->useS3ForStorage && $this->existsOnS3($storagePath)) {
                Log::info('Video already exists on S3', ['video_id' => $videoId]);
                return $storagePath;
            }
            // Legacy: check local disk
            if (Storage::disk($this->disk)->exists($storagePath)) {
                Log::info('Video already exists (local)', ['video_id' => $videoId]);
                return $storagePath;
            }

            Log::info('Downloading video', ['video_id' => $videoId]);

            // Download to temp file
            $response = $this->client->get($videoUrl, ['sink' => $tempPath]);

            if ($response->getStatusCode() !== 200) {
                Log::error('Download failed', [
                    'video_id' => $videoId,
                    'status' => $response->getStatusCode()
                ]);
                if (file_exists($tempPath)) {
                    @unlink($tempPath);
                }
                return null;
            }

            if (!file_exists($tempPath)) {
                Log::error('Temp file not created', ['video_id' => $videoId]);
                return null;
            }

            $sizeInMB = filesize($tempPath) / (1024 * 1024);
            if ($sizeInMB < 0.1) {
                Log::error('File too small', ['video_id' => $videoId, 'size_mb' => $sizeInMB]);
                @unlink($tempPath);
                return null;
            }

            // Store on S3 (primary) — same path so URL stays /storage/videos/tiktok/...
            if ($this->useS3ForStorage && config('filesystems.disks.s3.bucket')) {
                try {
                    $contents = file_get_contents($tempPath);
                    Storage::disk('s3')->put($storagePath, $contents); // private; served via app route (same URL for SEO)
                    Log::info('Video stored on S3', [
                        'video_id' => $videoId,
                        'path' => $storagePath,
                        'size_mb' => round($sizeInMB, 2)
                    ]);
                } catch (\Throwable $e) {
                    Log::error('S3 upload failed', ['video_id' => $videoId, 'error' => $e->getMessage()]);
                    @unlink($tempPath);
                    return null;
                }
            }

            // ---------- EXISTING LOCAL-ONLY STORAGE (commented, not removed) ----------
            // $fullPath = storage_path("app/public/{$storagePath}");
            // if (file_exists($fullPath)) { return $storagePath; }
            // rename($tempPath, $fullPath);
            // ---------- END COMMENTED LOCAL STORAGE ----------

            if (file_exists($tempPath)) {
                @unlink($tempPath);
            }

            return $storagePath;
        } catch (RequestException $e) {
            Log::error('Request failed', ['video_id' => $videoId, 'error' => $e->getMessage()]);
            if (file_exists($tempPath)) {
                @unlink($tempPath);
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Download exception', ['video_id' => $videoId, 'error' => $e->getMessage()]);
            if (file_exists($tempPath)) {
                @unlink($tempPath);
            }
            return null;
        }
    }

    /**
     * Generate filename
     */
    private function generateFilename($videoId, $username)
    {
        $cleanUsername = preg_replace('/[^a-z0-9_-]/i', '', $username);
        return "{$cleanUsername}_{$videoId}_" . time() . ".mp4";
    }

    /**
     * Get full URL from database path (same URL format for SEO — no change).
     *
     * @param string $storagePath Path from database like "videos/tiktok/file.mp4"
     * @return string Full URL
     */
    public function getUrl($storagePath)
    {
        return Storage::disk($this->disk)->url($storagePath);
    }

    /**
     * Check if video file exists (S3 or local).
     *
     * @param string $storagePath Path from database
     * @return bool
     */
    public function exists($storagePath)
    {
        if ($this->existsOnS3($storagePath)) {
            return true;
        }
        return Storage::disk($this->disk)->exists($storagePath);
    }

    /**
     * Delete video file from S3 and/or local.
     *
     * @param string $storagePath Path from database
     * @return bool
     */
    public function delete($storagePath)
    {
        $deleted = false;
        try {
            if ($this->existsOnS3($storagePath)) {
                Storage::disk('s3')->delete($storagePath);
                Log::info('Video deleted from S3', ['path' => $storagePath]);
                $deleted = true;
            }
            if (Storage::disk($this->disk)->exists($storagePath)) {
                Storage::disk($this->disk)->delete($storagePath);
                Log::info('Video deleted (local)', ['path' => $storagePath]);
                $deleted = true;
            }
            return $deleted;
        } catch (\Exception $e) {
            Log::error('Delete failed', ['path' => $storagePath, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Check if local/S3 video exists and is valid (path or URL).
     *
     * @param string $localPath Storage path or full URL
     * @return bool
     */
    public function videoExists($localPath)
    {
        try {
            if (empty($localPath)) {
                return false;
            }
            $path = $this->normalizeStoragePath($localPath);
            if ($this->existsOnS3($path)) {
                $size = Storage::disk('s3')->size($path);
                return $size > 0;
            }
            if (!Storage::disk($this->disk)->exists($path)) {
                return false;
            }
            $size = Storage::disk($this->disk)->size($path);
            return $size > 0;
        } catch (\Exception $e) {
            Log::error('videoExists check failed', ['path' => $localPath, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Delete local/S3 video file (path or URL).
     *
     * @param string $localPath Storage path or full URL
     * @return bool
     */
    public function deleteVideo($localPath)
    {
        try {
            if (empty($localPath)) {
                return false;
            }
            $path = $this->normalizeStoragePath($localPath);
            return $this->delete($path);
        } catch (\Exception $e) {
            Log::error('Failed to delete video', ['path' => $localPath, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get video file size (S3 or local).
     *
     * @param string $localPath Storage path or full URL
     * @return int|null Size in bytes
     */
    public function getVideoSize($localPath)
    {
        try {
            if (empty($localPath)) {
                return null;
            }
            $path = $this->normalizeStoragePath($localPath);
            if ($this->existsOnS3($path)) {
                return Storage::disk('s3')->size($path);
            }
            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->size($path);
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Failed to get video size', ['path' => $localPath, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
