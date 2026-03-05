<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

/**
 * Serves a WhatsApp/social-crawler-optimized image for blog link previews.
 * - Resized to max 1200×630 (WhatsApp recommendation)
 * - Output as JPEG (WhatsApp prefers JPG/PNG; JPEG keeps size down)
 * - Kept under 600KB (WhatsApp limit)
 * - Absolute URL used in og:image so crawlers can fetch it.
 */
class OgImageController extends Controller
{
    private const MAX_WIDTH = 1200;

    private const MAX_HEIGHT = 630;

    private const MAX_BYTES = 600 * 1024; // 600KB

    public function __invoke(string $slug): Response|\Illuminate\Http\RedirectResponse
    {
        $blog = Blog::query()
            ->where('slug', $slug)
            ->first();

        if (! $blog || empty($blog->file)) {
            return $this->redirectToFallback();
        }

        $path = storage_path('app/public/' . $blog->file);
        if (! is_file($path) || ! is_readable($path)) {
            return $this->redirectToFallback();
        }

        $mime = mime_content_type($path);
        if (! $mime || ! str_starts_with($mime, 'image/')) {
            return $this->redirectToFallback();
        }

        $image = $this->loadImage($path, $mime);
        if (! $image) {
            return $this->redirectToFallback();
        }

        $resized = $this->resizeToFit($image, self::MAX_WIDTH, self::MAX_HEIGHT);
        imagedestroy($image);
        if (! $resized) {
            return $this->redirectToFallback();
        }

        $jpeg = $this->toJpegUnderSize($resized, self::MAX_BYTES);
        imagedestroy($resized);
        if ($jpeg === null) {
            return $this->redirectToFallback();
        }

        return response($jpeg, 200, [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'public, max-age=86400', // 1 day
            'Content-Length' => (string) strlen($jpeg),
        ]);
    }

    private function loadImage(string $path, string $mime): \GdImage|false
    {
        return match (true) {
            str_contains($mime, 'jpeg') || str_contains($mime, 'jpg') => @imagecreatefromjpeg($path),
            str_contains($mime, 'png') => @imagecreatefrompng($path),
            str_contains($mime, 'gif') => @imagecreatefromgif($path),
            str_contains($mime, 'webp') => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    private function resizeToFit(\GdImage $image, int $maxW, int $maxH): \GdImage|false
    {
        $w = imagesx($image);
        $h = imagesy($image);
        if ($w <= 0 || $h <= 0) {
            return false;
        }
        if ($w <= $maxW && $h <= $maxH) {
            $newW = $w;
            $newH = $h;
        } else {
            $ratio = min($maxW / $w, $maxH / $h);
            $newW = (int) round($w * $ratio);
            $newH = (int) round($h * $ratio);
        }
        $newW = max(1, $newW);
        $newH = max(1, $newH);

        $out = imagecreatetruecolor($newW, $newH);
        if (! $out) {
            return false;
        }
        if (! imagecopyresampled($out, $image, 0, 0, 0, 0, $newW, $newH, $w, $h)) {
            imagedestroy($out);
            return false;
        }
        return $out;
    }

    /** @return string|null JPEG binary, or null if cannot stay under maxBytes */
    private function toJpegUnderSize(\GdImage $image, int $maxBytes): ?string
    {
        $quality = 85;
        while ($quality >= 50) {
            ob_start();
            imagejpeg($image, null, $quality);
            $jpeg = ob_get_clean();
            if ($jpeg !== false && strlen($jpeg) <= $maxBytes) {
                return $jpeg;
            }
            $quality -= 10;
        }
        ob_start();
        imagejpeg($image, null, 50);
        $jpeg = ob_get_clean();
        return ($jpeg !== false && strlen($jpeg) <= $maxBytes) ? $jpeg : null;
    }

    private function redirectToFallback(): \Illuminate\Http\RedirectResponse
    {
        $url = absolute_og_url(site_logo());
        return redirect()->away($url, 302);
    }
}
