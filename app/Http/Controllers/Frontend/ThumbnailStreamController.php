<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves TikTok thumbnails from S3 with local fallback.
 * URL remains /storage/thumbnails/{path} for SEO (no redirect, same URL).
 */
class ThumbnailStreamController extends Controller
{
    private const THUMBNAIL_PATH_PREFIX = 'thumbnails/';

    /**
     * Stream thumbnail image from S3 or local disk. Preserves same public URL for SEO.
     */
    public function stream(string $path): StreamedResponse
    {
        $storagePath = self::THUMBNAIL_PATH_PREFIX . $path;

        // Security: path must not contain .. or absolute segments
        if (preg_match('#\.\.|^/|\\\\#', $path)) {
            abort(404);
        }

        // 1) Try S3 first (primary storage for new thumbnails)
        if (config('filesystems.disks.s3.bucket')) {
            try {
                if (Storage::disk('s3')->exists($storagePath)) {
                    return $this->streamFromS3($storagePath);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // 2) Fallback: local disk (existing thumbnails / legacy)
        if (Storage::disk('public')->exists($storagePath)) {
            return $this->streamFromLocal($storagePath);
        }

        abort(404);
    }

    private function mimeType(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }

    private function streamFromS3(string $storagePath): StreamedResponse
    {
        $disk = Storage::disk('s3');
        $size = $disk->size($storagePath);

        return response()->stream(function () use ($disk, $storagePath) {
            $stream = $disk->readStream($storagePath);
            if (is_resource($stream)) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $this->mimeType($storagePath),
            'Content-Length' => $size,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    private function streamFromLocal(string $storagePath): StreamedResponse
    {
        $fullPath = Storage::disk('public')->path($storagePath);
        $size = filesize($fullPath);

        return response()->stream(function () use ($fullPath) {
            $stream = fopen($fullPath, 'rb');
            if (is_resource($stream)) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $this->mimeType($storagePath),
            'Content-Length' => $size,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
