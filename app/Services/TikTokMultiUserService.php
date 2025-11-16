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

    public function getUserProfile($username)
    {
        // Check if API key exists
        if (empty($this->apiKey)) {
            Log::error("TikTok API key not configured");
            return [
                'success' => false,
                'error' => 'API key not configured',
                'data' => null,
            ];
        }

        $cacheKey = "tiktok_profile_{$username}";
        
        return Cache::remember($cacheKey, 3600, function() use ($username) {
            try {
                $response = $this->client->get($this->baseUrl . 'user/info', [
                    'headers' => [
                        'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                        'x-rapidapi-key' => $this->apiKey,
                    ],
                    'query' => ['unique_id' => $username],
                ]);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();

                Log::info("TikTok Profile API Response", [
                    'username' => $username,
                    'status' => $statusCode,
                    'body_length' => strlen($body)
                ]);

                if ($statusCode === 403) {
                    return [
                        'success' => false,
                        'error' => 'API subscription required. Subscribe at: https://rapidapi.com/DataFanatic/api/tiktok-scraper7',
                        'data' => null,
                    ];
                }

                if ($statusCode !== 200) {
                    return [
                        'success' => false,
                        'error' => "API returned status code: {$statusCode}",
                        'data' => null,
                    ];
                }

                $data = json_decode($body, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [
                        'success' => false,
                        'error' => 'Invalid JSON response from API',
                        'data' => null,
                    ];
                }

                $userData = $data['data'] ?? $data;
                
                return [
                    'success' => true,
                    'data' => $userData,
                ];
            } catch (\Exception $e) {
                Log::error("TikTok Profile Error ({$username}): " . $e->getMessage());
                
                return [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'data' => null,
                ];
            }
        });
    }

    public function getUserVideos($username, $count = 12)
    {
        if (empty($this->apiKey)) {
            Log::error("TikTok API key not configured");
            return [
                'success' => false,
                'error' => 'API key not configured',
                'videos' => [],
                'user' => null,
            ];
        }

        $cacheKey = "tiktok_videos_{$username}_{$count}";
        
        return Cache::remember($cacheKey, 1800, function() use ($username, $count) {
            try {
                // First get profile to extract user ID
                $profileResponse = $this->getUserProfile($username);
                
                if (!$profileResponse['success']) {
                    return [
                        'success' => false,
                        'error' => $profileResponse['error'] ?? 'Failed to get user profile',
                        'videos' => [],
                        'user' => null,
                    ];
                }

                $userId = $profileResponse['data']['user']['id'] ?? null;
                
                if (!$userId) {
                    return [
                        'success' => false,
                        'error' => 'User ID not found in profile response',
                        'videos' => [],
                        'user' => null,
                    ];
                }

                // Fetch videos using user ID
                $response = $this->client->get($this->baseUrl . 'user/posts', [
                    'headers' => [
                        'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                        'x-rapidapi-key' => $this->apiKey,
                    ],
                    'query' => [
                        'user_id' => $userId,
                        'count' => $count,
                    ],
                ]);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();
                
                Log::info("TikTok Videos API Response", [
                    'username' => $username,
                    'user_id' => $userId,
                    'status' => $statusCode,
                    'body_length' => strlen($body)
                ]);

                if ($statusCode === 403) {
                    return [
                        'success' => false,
                        'error' => 'API subscription required. Subscribe at: https://rapidapi.com/DataFanatic/api/tiktok-scraper7',
                        'videos' => [],
                        'user' => $profileResponse['data']['user'] ?? null,
                    ];
                }

                if ($statusCode !== 200) {
                    return [
                        'success' => false,
                        'error' => "API returned status code: {$statusCode}",
                        'videos' => [],
                        'user' => $profileResponse['data']['user'] ?? null,
                    ];
                }

                $data = json_decode($body, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [
                        'success' => false,
                        'error' => 'Invalid JSON response from API',
                        'videos' => [],
                        'user' => $profileResponse['data']['user'] ?? null,
                    ];
                }
                
                // Extract videos from various possible response structures
                $videos = [];
                
                if (isset($data['data']['videos'])) {
                    $videos = $data['data']['videos'];
                } elseif (isset($data['videos'])) {
                    $videos = $data['videos'];
                } elseif (isset($data['data']['aweme_list'])) {
                    $videos = $data['data']['aweme_list'];
                } elseif (isset($data['aweme_list'])) {
                    $videos = $data['aweme_list'];
                } elseif (isset($data['data']) && is_array($data['data']) && isset($data['data'][0])) {
                    $videos = $data['data'];
                }
                
                Log::info("Videos extracted", [
                    'username' => $username,
                    'count' => count($videos)
                ]);
                
                // Add username to each video
                foreach ($videos as &$video) {
                    $video['_username'] = $username;
                }
                
                // Limit to requested count
                $videos = array_slice($videos, 0, $count);
                
                if (empty($videos)) {
                    Log::warning("No videos found for user: {$username}");
                }
                
                return [
                    'success' => true,
                    'videos' => $videos,
                    'user' => $data['data']['user'] ?? $data['user'] ?? $profileResponse['data']['user'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::error("TikTok Videos Error ({$username}): " . $e->getMessage());
                
                return [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'videos' => [],
                    'user' => null,
                ];
            }
        });
    }

    public function getMultipleProfiles(array $usernames)
    {
        $profiles = [];
        
        foreach ($usernames as $username) {
            $profile = $this->getUserProfile($username);
            if ($profile['success'] && $profile['data']) {
                $profiles[$username] = $profile['data'];
            }
        }
        
        return $profiles;
    }

    public function getMultipleUsersVideos(array $usernames, $videosPerUser = 12)
    {
        $allVideos = [];
        
        foreach ($usernames as $username) {
            $result = $this->getUserVideos($username, $videosPerUser);
            
            if ($result['success'] && !empty($result['videos'])) {
                foreach ($result['videos'] as $video) {
                    $video['_username'] = $username;
                    $allVideos[] = $video;
                }
            }
        }
        
        // Sort by creation time (newest first)
        usort($allVideos, function ($a, $b) {
            $timeA = $a['create_time'] ?? $a['createTime'] ?? 0;
            $timeB = $b['create_time'] ?? $b['createTime'] ?? 0;
            return $timeB - $timeA;
        });
        
        return $allVideos;
    }

    public function clearUserCache($username)
    {
        Cache::forget("tiktok_profile_{$username}");
        
        // Clear video caches for various counts
        for ($i = 1; $i <= 50; $i++) {
            Cache::forget("tiktok_videos_{$username}_{$i}");
        }
    }

    public function clearAllCache()
    {
        $users = config('tiktok.featured_users');
        foreach ($users as $user) {
            $this->clearUserCache($user['username']);
        }
    }

    public function getFeaturedUsers()
    {
        return config('tiktok.featured_users', []);
    }
    
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
            $response = $this->client->get($this->baseUrl . 'user/info', [
                'headers' => [
                    'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
                    'x-rapidapi-key' => $this->apiKey,
                ],
                'query' => ['unique_id' => 'tiktok'],
            ]);

            $statusCode = $response->getStatusCode();

            if ($statusCode === 403) {
                return [
                    'success' => false,
                    'status' => 403,
                    'error' => 'Not subscribed to API',
                    'message' => 'Please subscribe at: https://rapidapi.com/DataFanatic/api/tiktok-scraper7',
                ];
            }

            if ($statusCode === 200) {
                return [
                    'success' => true,
                    'status' => 200,
                    'message' => 'API connection successful',
                ];
            }

            return [
                'success' => false,
                'status' => $statusCode,
                'error' => "Unexpected status code: {$statusCode}",
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

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
}