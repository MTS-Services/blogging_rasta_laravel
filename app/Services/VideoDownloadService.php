<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class VideoDownloadService
{
    protected $client;
    protected $disk = 'public';
    protected $videoPath = 'videos/tiktok';

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

        $fullDirPath = storage_path("app/public/{$this->videoPath}");
        if (!file_exists($fullDirPath)) {
            mkdir($fullDirPath, 0755, true);
        }
    }

    /**
     * Download and store video - Returns storage path for database
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
        $storagePath = "{$this->videoPath}/{$filename}"; // Path to save in database
        $fullPath = storage_path("app/public/{$storagePath}");
        $tempPath = $fullPath . '.tmp';

        try {
            // Check if already exists
            if (file_exists($fullPath)) {
                Log::info('Video already exists', ['video_id' => $videoId]);
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
                if (file_exists($tempPath))
                    unlink($tempPath);
                return null;
            }

            // Verify file
            if (!file_exists($tempPath)) {
                Log::error('Temp file not created', ['video_id' => $videoId]);
                return null;
            }

            $sizeInMB = filesize($tempPath) / (1024 * 1024);

            if ($sizeInMB < 0.1) {
                Log::error('File too small', ['video_id' => $videoId, 'size_mb' => $sizeInMB]);
                unlink($tempPath);
                return null;
            }

            // Move to final location
            rename($tempPath, $fullPath);

            Log::info('Video downloaded successfully', [
                'video_id' => $videoId,
                'path' => $storagePath,
                'size_mb' => round($sizeInMB, 2)
            ]);

            // Return path for database: "videos/tiktok/username_id_timestamp.mp4"
            return $storagePath;

        } catch (RequestException $e) {
            Log::error('Request failed', [
                'video_id' => $videoId,
                'error' => $e->getMessage()
            ]);
            if (file_exists($tempPath))
                unlink($tempPath);
            return null;

        } catch (\Exception $e) {
            Log::error('Download exception', [
                'video_id' => $videoId,
                'error' => $e->getMessage()
            ]);
            if (file_exists($tempPath))
                unlink($tempPath);
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
     * Get full URL from database path
     *
     * @param string $storagePath Path from database like "videos/tiktok/file.mp4"
     * @return string Full URL
     */
    public function getUrl($storagePath)
    {
        return Storage::disk($this->disk)->url($storagePath);
    }

    /**
     * Check if video file exists
     *
     * @param string $storagePath Path from database
     * @return bool
     */
    public function exists($storagePath)
    {
        return Storage::disk($this->disk)->exists($storagePath);
    }

    /**
     * Delete video file
     *
     * @param string $storagePath Path from database
     * @return bool
     */
    public function delete($storagePath)
    {
        try {
            if (Storage::disk($this->disk)->exists($storagePath)) {
                Storage::disk($this->disk)->delete($storagePath);
                Log::info('Video deleted', ['path' => $storagePath]);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Delete failed', ['path' => $storagePath, 'error' => $e->getMessage()]);
            return false;
        }
    }


    /**
     * Check if local video exists and is valid
     *
     * @param string $localPath
     * @return bool
     */
    public function videoExists($localPath)
    {
        try {
            if (empty($localPath)) {
                return false;
            }

            // Extract path from URL more reliably
            $path = str_replace([
                Storage::disk($this->disk)->url(''),
                url('storage/'),
                url('/storage/')
            ], '', $localPath);

            // Clean up the path
            $path = ltrim($path, '/');

            if (!Storage::disk($this->disk)->exists($path)) {
                return false;
            }

            // Check if file has content
            $size = Storage::disk($this->disk)->size($path);
            return $size > 0;

        } catch (\Exception $e) {
            Log::error('videoExists check failed', [
                'path' => $localPath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Delete local video file
     *
     * @param string $localPath
     * @return bool
     */
    public function deleteVideo($localPath)
    {
        try {
            if (empty($localPath)) {
                return false;
            }

            // Extract path from full URL if needed
            $path = str_replace(Storage::disk($this->disk)->url(''), '', $localPath);

            if (Storage::disk($this->disk)->exists($path)) {
                Storage::disk($this->disk)->delete($path);
                Log::info('Video deleted successfully', ['path' => $path]);
                return true;
            }

            return false;

        } catch (\Exception $e) {
            Log::error('Failed to delete video', [
                'path' => $localPath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get video file size
     *
     * @param string $localPath
     * @return int|null Size in bytes
     */
    public function getVideoSize($localPath)
    {
        try {
            $path = str_replace(Storage::disk($this->disk)->url(''), '', $localPath);

            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->size($path);
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Failed to get video size', [
                'path' => $localPath,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}
