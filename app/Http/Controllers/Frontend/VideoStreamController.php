<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves TikTok videos from S3 with local fallback.
 * URL remains /storage/videos/tiktok/{path} for SEO (no redirect, same URL).
 * Supports HTTP Range requests for video seeking.
 */
class VideoStreamController extends Controller
{
    private const VIDEO_PATH_PREFIX = 'videos/tiktok/';

    /**
     * Stream video from S3 or local disk. Preserves same public URL for SEO.
     */
    public function stream(Request $request, string $path): StreamedResponse
    {
        $storagePath = self::VIDEO_PATH_PREFIX . $path;

        if (preg_match('#\.\.|^/|\\\\#', $path)) {
            abort(404);
        }

        // 1) Try S3 first
        if (config('filesystems.disks.s3.bucket')) {
            try {
                if (Storage::disk('s3')->exists($storagePath)) {
                    return $this->streamFromS3($request, $storagePath);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // 2) Fallback: local disk
        if (Storage::disk('public')->exists($storagePath)) {
            return $this->streamFromLocal($request, $storagePath);
        }

        abort(404);
    }

    private function streamFromS3(Request $request, string $storagePath): StreamedResponse
    {
        $disk = Storage::disk('s3');
        $size = $disk->size($storagePath);

        return $this->buildRangeResponse($request, $size, function (int $start, int $length) use ($disk, $storagePath) {
            $stream = $disk->readStream($storagePath);
            if (is_resource($stream)) {
                fseek($stream, $start);
                echo stream_get_contents($stream, $length);
                fclose($stream);
            }
        });
    }

    private function streamFromLocal(Request $request, string $storagePath): StreamedResponse
    {
        $fullPath = Storage::disk('public')->path($storagePath);
        $size = filesize($fullPath);

        return $this->buildRangeResponse($request, $size, function (int $start, int $length) use ($fullPath) {
            $stream = fopen($fullPath, 'rb');
            if (is_resource($stream)) {
                fseek($stream, $start);
                echo fread($stream, $length);
                fclose($stream);
            }
        });
    }

    /**
     * Build a response that supports HTTP Range requests for video seeking.
     */
    private function buildRangeResponse(Request $request, int $fileSize, callable $outputCallback): StreamedResponse
    {
        $mime = 'video/mp4';
        $rangeHeader = $request->header('Range');

        if ($rangeHeader && preg_match('/bytes=(\d+)-(\d*)/', $rangeHeader, $matches)) {
            $start = (int) $matches[1];
            $end = !empty($matches[2]) ? (int) $matches[2] : $fileSize - 1;
            $end = min($end, $fileSize - 1);
            $length = $end - $start + 1;

            return response()->stream(function () use ($outputCallback, $start, $length) {
                $outputCallback($start, $length);
            }, 206, [
                'Content-Type' => $mime,
                'Content-Length' => $length,
                'Content-Range' => "bytes {$start}-{$end}/{$fileSize}",
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }

        return response()->stream(function () use ($outputCallback, $fileSize) {
            $outputCallback(0, $fileSize);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
