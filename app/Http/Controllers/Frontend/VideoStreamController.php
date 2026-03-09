<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves TikTok videos from S3 with local fallback.
 * URL remains /storage/videos/tiktok/{path} for SEO (no redirect, same URL).
 */
class VideoStreamController extends Controller
{
    private const VIDEO_PATH_PREFIX = 'videos/tiktok/';

    /**
     * Stream video from S3 or local disk. Preserves same public URL for SEO.
     */
    public function stream(string $path): StreamedResponse
    {
        $storagePath = self::VIDEO_PATH_PREFIX . $path;

        // Security: path must not contain .. or absolute segments
        if (preg_match('#\.\.|^/|\\\\#', $path)) {
            abort(404);
        }

        // 1) Try S3 first (primary storage for new videos)
        if (config('filesystems.disks.s3.bucket')) {
            try {
                if (Storage::disk('s3')->exists($storagePath)) {
                    return $this->streamFromS3($storagePath);
                }
            } catch (\Throwable $e) {
                report($e);
                // Fall through to local
            }
        }

        // 2) Fallback: local disk (existing videos / legacy)
        if (Storage::disk('public')->exists($storagePath)) {
            return $this->streamFromLocal($storagePath);
        }

        abort(404);
    }

    private function streamFromS3(string $storagePath): StreamedResponse
    {
        $disk = Storage::disk('s3');
        $size = $disk->size($storagePath);
        $mime = 'video/mp4';

        return response()->stream(function () use ($disk, $storagePath) {
            $stream = $disk->readStream($storagePath);
            if (is_resource($stream)) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    private function streamFromLocal(string $storagePath): StreamedResponse
    {
        $fullPath = Storage::disk('public')->path($storagePath);
        $size = filesize($fullPath);
        $mime = 'video/mp4';

        return response()->stream(function () use ($fullPath) {
            $stream = fopen($fullPath, 'rb');
            if (is_resource($stream)) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
