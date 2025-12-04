<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ThumbnailDownloadService
{
    /**
     * Download thumbnail from TikTok CDN and store locally
     */
    public function downloadAndStore(string $tiktokUrl, string $awemeId): ?string
    {
        if (empty($tiktokUrl)) {
            return null;
        }

        try {
            // Download with proper headers to bypass TikTok restrictions
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Referer' => 'https://www.tiktok.com/',
                'Accept' => 'image/*',
            ])->timeout(30)->get($tiktokUrl);

            if (!$response->successful()) {
                Log::warning("Failed to download thumbnail", ['url' => $tiktokUrl]);
                return null;
            }

            // Generate filename
            $extension = $this->getImageExtension($response->header('Content-Type'));
            $filename = "thumbnails/{$awemeId}.{$extension}";

            // Store in public disk
            Storage::disk('public')->put($filename, $response->body());

            // Return public URL
            return Storage::disk('public')->url($filename);

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
        return match($contentType) {
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }
}

