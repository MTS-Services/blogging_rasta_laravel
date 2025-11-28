<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TikTokMultiUserService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl = 'https://tiktok-scraper7.p.rapidapi.com/';

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
            'http_errors' => false
        ]);
        $this->apiKey = config('tiktok.rapidapi_key');
    }

    /**
     * Get user videos with pagination support
     *
     * @param string $username TikTok username
     * @param int $count Number of videos per page (default: 12)
     * @param string|int $cursor Pagination cursor (default: 0)
     * @return array
     */
    public function getUserVideos($username, $count = 12, $cursor = 0)
    {
        if (empty($this->apiKey)) {
            Log::error("TikTok API key not configured");
            return $this->errorResponse('API key not configured');
        }

        $cacheKey = "tiktok_videos_{$username}_{$count}_{$cursor}";

        // return Cache::remember($cacheKey, 1800, function() use ($username, $count, $cursor) {
            try {
                $response = $this->client->get($this->baseUrl . 'user/posts', [
                    'headers' => [
                        'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                        'x-rapidapi-key' => $this->apiKey,
                    ],
                    'query' => [
                        'unique_id' => $username,
                        'count' => $count,
                        'cursor' => $cursor,
                    ],
                ]);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();

                Log::info("TikTok API Response", [
                    'username' => $username,
                    'status' => $statusCode,
                    'cursor' => $cursor,
                    'body_length' => strlen($body)
                ]);

                if ($statusCode === 403) {
                    return $this->errorResponse('API subscription required. Subscribe at: https://rapidapi.com/DataFanatic/api/tiktok-scraper7');
                }

                if ($statusCode !== 200) {
                    return $this->errorResponse("API returned status code: {$statusCode}");
                }

                $data = json_decode($body, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    return $this->errorResponse('Invalid JSON response from API');
                }

                // Check API response code
                if (isset($data['code']) && $data['code'] !== 0) {
                    return $this->errorResponse($data['msg'] ?? 'API request failed');
                }

                // Extract data from response
                $responseData = $data['data'] ?? [];
                $videos = $responseData['videos'] ?? [];
                $hasMore = $responseData['hasMore'] ?? false;
                $nextCursor = $responseData['cursor'] ?? 0;

                // Add username to each video for identification
                foreach ($videos as &$video) {
                    $video['_username'] = $username;
                }

                // Extract user info from first video's author
                $user = null;
                if (!empty($videos) && isset($videos[0]['author'])) {
                    $user = $videos[0]['author'];
                }

                Log::info("Videos loaded successfully", [
                    'username' => $username,
                    'count' => count($videos),
                    'has_more' => $hasMore,
                    'next_cursor' => $nextCursor
                ]);

                return [
                    'success' => true,
                    'videos' => $videos,
                    'user' => $user,
                    'has_more' => $hasMore,
                    'cursor' => $nextCursor,
                    'total_loaded' => count($videos),
                ];

            } catch (\Exception $e) {
                Log::error("TikTok Videos Error ({$username}): " . $e->getMessage());
                return $this->errorResponse($e->getMessage());
            }
        // });
    }

    /**
     * Get paginated videos from multiple users
     *
     * @param array $usernames Array of TikTok usernames
     * @param int $videosPerUser Videos per user per page
     * @param array $cursors Array of cursors for each user [username => cursor]
     * @param array $userVideoLimits Array of max videos per user [username => limit]
     * @param array $userVideoCounts Array tracking loaded videos [username => count]
     * @return array
     */
    public function getMultipleUsersVideos(
        array $usernames,
        $videosPerUser = 12,
        array $cursors = [],
        array $userVideoLimits = [],
        array $userVideoCounts = []
    ) {
        $allVideos = [];
        $usersCursors = [];
        $usersHasMore = [];
        $updatedCounts = $userVideoCounts;

        foreach ($usernames as $username) {
            // Check if user has reached their limit
            $maxLimit = $userVideoLimits[$username] ?? null;
            $currentCount = $userVideoCounts[$username] ?? 0;

            if ($maxLimit !== null && $currentCount >= $maxLimit) {
                // User has reached their limit, skip
                $usersHasMore[$username] = false;
                $usersCursors[$username] = $cursors[$username] ?? 0;
                continue;
            }

            $cursor = $cursors[$username] ?? 0;
            $result = $this->getUserVideos($username, $videosPerUser, $cursor);

            if ($result['success'] && !empty($result['videos'])) {
                $videosToAdd = $result['videos'];

                // If user has a limit, enforce it
                if ($maxLimit !== null) {
                    $remaining = $maxLimit - $currentCount;
                    if ($remaining < count($videosToAdd)) {
                        $videosToAdd = array_slice($videosToAdd, 0, $remaining);
                        $usersHasMore[$username] = false; // Reached limit
                    } else {
                        $usersHasMore[$username] = $result['has_more'];
                    }

                    // Update count
                    $updatedCounts[$username] = $currentCount + count($videosToAdd);
                } else {
                    $usersHasMore[$username] = $result['has_more'];
                }

                foreach ($videosToAdd as $video) {
                    $allVideos[] = $video;
                }

                // Store pagination info for each user
                $usersCursors[$username] = $result['cursor'];
            }
        }

        // Sort by creation time (newest first)
        usort($allVideos, function ($a, $b) {
            $timeA = $a['create_time'] ?? 0;
            $timeB = $b['create_time'] ?? 0;
            return $timeB - $timeA;
        });

        return [
            'success' => true,
            'videos' => $allVideos,
            'cursors' => $usersCursors,
            'has_more' => $usersHasMore,
            'total_videos' => count($allVideos),
            'video_counts' => $updatedCounts,
        ];
    }

    /**
     * Clear cache for specific user
     */
    public function clearUserCache($username)
    {
        // Clear all cursor-based caches for this user
        for ($count = 1; $count <= 50; $count++) {
            for ($cursor = 0; $cursor <= 10; $cursor++) {
                Cache::forget("tiktok_videos_{$username}_{$count}_{$cursor}");
            }
        }

        Log::info("Cache cleared for user: {$username}");
    }

    /**
     * Clear all cached data
     */
    public function clearAllCache()
    {
        $users = config('tiktok.featured_users', []);
        foreach ($users as $user) {
            $this->clearUserCache($user['username']);
        }

        Log::info("All TikTok cache cleared");
    }

    /**
     * Get featured users from config
     */
    public function getFeaturedUsers()
    {
        return config('tiktok.featured_users', []);
    }

    /**
     * Test API connection
     */
    public function testConnection()
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'RAPIDAPI_KEY not configured',
                'message' => 'Please add RAPIDAPI_KEY to your .env file',
            ];
        }

        try {
            $response = $this->client->get($this->baseUrl . 'user/posts', [
                'headers' => [
                    'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                    'x-rapidapi-key' => $this->apiKey,
                ],
                'query' => [
                    'unique_id' => 'tiktok',
                    'count' => 1,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode === 403) {
                return [
                    'success' => false,
                    'status' => 403,
                    'error' => 'Not subscribed to API',
                    'message' => 'Please subscribe at: https://rapidapi.com/DataFanatic/api/tiktok-scraper7',
                ];
            }

            if ($statusCode === 200 && isset($body['code']) && $body['code'] === 0) {
                return [
                    'success' => true,
                    'status' => 200,
                    'message' => 'API connection successful',
                ];
            }

            return [
                'success' => false,
                'status' => $statusCode,
                'error' => "Unexpected response: " . ($body['msg'] ?? 'Unknown error'),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Format large numbers for display
     */
    public function formatNumber($number)
    {
        if (!is_numeric($number)) {
            return '0';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }

        return number_format($number);
    }

    /**
     * Return standardized error response
     */
    private function errorResponse($message)
    {
        return [
            'success' => false,
            'error' => $message,
            'videos' => [],
            'user' => null,
            'has_more' => false,
            'cursor' => 0,
            'total_loaded' => 0,
        ];
    }
}
