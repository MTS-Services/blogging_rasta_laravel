<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageProxyController extends Controller
{
    public function proxy(Request $request): StreamedResponse
    {
        $url = $request->query('url');

        if (!$url || !$this->isValidTikTokUrl($url)) {
            abort(400, 'Invalid URL');
        }

        $cacheKey = 'image_proxy_' . md5($url);

        $imageData = Cache::remember($cacheKey, 3600, function () use ($url) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Referer' => 'https://www.tiktok.com/',
                    'Accept' => 'image/*',
                ])->timeout(30)->get($url);

                if ($response->successful()) {
                    return [
                        'body' => $response->body(),
                        'content_type' => $response->header('Content-Type', 'image/jpeg'),
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Image proxy error', ['url' => $url, 'error' => $e->getMessage()]);
            }

            return null;
        });

        if (!$imageData) {
            abort(404, 'Image not found');
        }

        return response()->streamDownload(
            function () use ($imageData) {
                echo $imageData['body'];
            },
            'image.jpg',
            [
                'Content-Type' => $imageData['content_type'],
                'Cache-Control' => 'public, max-age=3600',
            ]
        );
    }

    protected function isValidTikTokUrl(string $url): bool
    {
        $allowedDomains = [
            'tiktokcdn.com',
            'tiktokcdn-eu.com',
            'tiktokcdn-us.com',
        ];

        $host = parse_url($url, PHP_URL_HOST);

        foreach ($allowedDomains as $domain) {
            if (str_ends_with($host, $domain)) {
                return true;
            }
        }

        return false;
    }
}
