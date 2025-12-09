<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class VideoDownloadService
{
    protected $client;
    protected $disk = 'public'; // Change to 's3' if using cloud storage
    protected $videoPath = 'videos/tiktok'; // Storage path for videos

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 300, // 5 minutes
            'connect_timeout' => 30,
            'read_timeout' => 300,
            'verify' => true,
            'http_errors' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept' => 'video/mp4,video/*,*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive',
            ]
        ]);

        // Ensure storage directory exists
        $fullDirPath = storage_path("app/{$this->disk}/{$this->videoPath}");
        if (!file_exists($fullDirPath)) {
            mkdir($fullDirPath, 0755, true);
            Log::info('Created video storage directory', ['path' => $fullDirPath]);
        }
    }

    /**
     * Download and store TikTok video locally
     *
     * @param string $videoUrl The TikTok CDN video URL
     * @param string $videoId The unique video ID
     * @param string $username The creator username
     * @return string|null Local storage path or null on failure
     */
    public function downloadAndStore($videoUrl, $videoId, $username = 'creator')
    {

        ini_set('max_execution_time', 0); // unlimited
        set_time_limit(0);
        if (empty($videoUrl)) {
            Log::warning('Empty video URL provided for download', ['video_id' => $videoId]);
            return null;
        }

        try {
            // Generate unique filename
            $filename = $this->generateFilename($videoId, $username);
            $fullPath = "{$this->videoPath}/{$filename}";

            // Check if video already exists
            if (Storage::disk($this->disk)->exists($fullPath)) {
                Log::info('Video already exists locally', [
                    'video_id' => $videoId,
                    'path' => $fullPath
                ]);
                return Storage::disk($this->disk)->url($fullPath);
            }

            Log::info('Starting video download', [
                'video_id' => $videoId,
                'url' => substr($videoUrl, 0, 100) . '...',
                'filename' => $filename
            ]);

            // Download with stream enabled
            $response = $this->client->get($videoUrl, [
                'stream' => true
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                Log::error('Failed to download video', [
                    'video_id' => $videoId,
                    'status_code' => $statusCode,
                    'url' => substr($videoUrl, 0, 100)
                ]);
                return null;
            }

            // Get response body as stream and save
            // $localPath = storage_path("app/{$this->disk}/{$fullPath}");
            $localPath = storage_path("app/public/{$fullPath}");

            $stream = $response->getBody();

            $handle = fopen($localPath, 'w');

            while (!$stream->eof()) {
                fwrite($handle, $stream->read(1024 * 1024)); // write in 1MB chunks
            }

            fclose($handle);

            $saved = Storage::disk($this->disk)->exists($fullPath);

            if (!$saved) {
                Log::error('Failed to save video to storage', [
                    'video_id' => $videoId,
                    'path' => $fullPath
                ]);
                return null;
            }

            // Verify file exists
            if (!Storage::disk($this->disk)->exists($fullPath)) {
                Log::error('Video not found after save', [
                    'video_id' => $videoId,
                    'path' => $fullPath
                ]);
                return null;
            }

            // Check file size
            $fileSize = Storage::disk($this->disk)->size($fullPath);
            $sizeInMB = $fileSize / (1024 * 1024);

            if ($sizeInMB < 0.1) {
                Log::error('Video file too small, likely invalid', [
                    'video_id' => $videoId,
                    'size_mb' => round($sizeInMB, 2)
                ]);

                Storage::disk($this->disk)->delete($fullPath);
                return null;
            }

            if ($sizeInMB > 100) {
                Log::warning('Video file very large', [
                    'video_id' => $videoId,
                    'size_mb' => round($sizeInMB, 2)
                ]);
            }

            $localUrl = Storage::disk($this->disk)->url($fullPath);

            Log::info('Video downloaded and stored successfully', [
                'video_id' => $videoId,
                'path' => $fullPath,
                'size_mb' => round($sizeInMB, 2),
                'local_url' => $localUrl
            ]);

            return $localUrl;

        } catch (\Exception $e) {
            Log::error('Exception while downloading video', [
                'video_id' => $videoId,
                'error' => $e->getMessage(),
                'type' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);

            // Clean up partial file if exists
            try {
                $fullPath = "{$this->videoPath}/" . $this->generateFilename($videoId, $username);
                if (Storage::disk($this->disk)->exists($fullPath)) {
                    Storage::disk($this->disk)->delete($fullPath);
                }
            } catch (\Exception $cleanupError) {
                // Ignore cleanup errors
            }

            return null;
        }
    }
    /**
     * Generate unique filename for video
     *
     * @param string $videoId
     * @param string $username
     * @return string
     */
    private function generateFilename($videoId, $username)
    {
        $cleanUsername = preg_replace('/[^a-z0-9_-]/i', '', $username);
        $timestamp = time();

        // Format: username_videoId_timestamp.mp4
        return "{$cleanUsername}_{$videoId}_{$timestamp}.mp4";
    }

    /**
     * Download video with retry mechanism
     *
     * @param string $videoUrl
     * @param string $videoId
     * @param string $username
     * @param int $maxRetries
     * @return string|null
     */
    public function downloadWithRetry($videoUrl, $videoId, $username = 'creator', $maxRetries = 3)
    {
        $attempt = 0;

        while ($attempt < $maxRetries) {
            $attempt++;

            Log::info('Attempting video download', [
                'video_id' => $videoId,
                'attempt' => $attempt,
                'max_retries' => $maxRetries
            ]);

            $result = $this->downloadAndStore($videoUrl, $videoId, $username);

            if ($result !== null) {
                return $result;
            }

            if ($attempt < $maxRetries) {
                // Wait before retry (exponential backoff)
                $waitSeconds = pow(2, $attempt);
                Log::info("Waiting {$waitSeconds}s before retry", [
                    'video_id' => $videoId,
                ]);
                sleep($waitSeconds);
            }
        }

        Log::error('All video download attempts failed', [
            'video_id' => $videoId,
            'attempts' => $maxRetries
        ]);

        return null;
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
}
