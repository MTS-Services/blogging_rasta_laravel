<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ThumbnailDownloadService
{
    /** Whether to store new thumbnails on S3 (true) or only on local (false). */
    protected bool $useS3ForStorage = false;

    /**
     * Download thumbnail from TikTok CDN and store (S3 primary; local commented).
     * Returns storage path so URL stays /storage/thumbnails/{path} for SEO.
     */
    public function downloadAndStore(string $tiktokUrl, string $videoId): ?string
    {
        if (empty($tiktokUrl)) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Referer' => 'https://www.tiktok.com/',
                'Accept' => 'image/*',
            ])->timeout(30)->get($tiktokUrl);

            if (!$response->successful()) {
                Log::warning("Failed to download thumbnail", ['url' => $tiktokUrl]);
                return null;
            }

            $extension = $this->getImageExtension($response->header('Content-Type'));
            $filename = "thumbnails/{$videoId}.{$extension}";
            $body = $response->body();

            // Store on S3 (primary) — same path so URL stays /storage/thumbnails/...
            if ($this->useS3ForStorage && config('filesystems.disks.s3.bucket')) {
                try {
                    Storage::disk('s3')->put($filename, $body);
                    Log::info('Thumbnail stored on S3', ['path' => $filename]);
                    return $filename;
                } catch (\Throwable $e) {
                    Log::error('Thumbnail S3 upload failed', ['video_id' => $videoId, 'error' => $e->getMessage()]);
                    return null;
                }
            }

            // ---------- EXISTING LOCAL-ONLY STORAGE (commented, not removed) ----------
            // Storage::disk('public')->put($filename, $body);
            // return Storage::disk('public')->url($filename);
            // ---------- END COMMENTED LOCAL STORAGE ----------

            // Fallback: store locally when S3 disabled
            Storage::disk('public')->put($filename, $body);
            return $filename;
        } catch (\Exception $e) {
            Log::error("Thumbnail download failed", [
                'url' => $tiktokUrl,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    protected function getImageExtension(?string $contentType): string
    {
        return match ($contentType) {
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }
}
