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
    protected $useDummyData = false;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
            'http_errors' => false
        ]);
        $this->apiKey = config('tiktok.rapidapi_key');
    }

    protected function getDummyVideos($username, $count = 12)
    {
        $videos = [];
        $themes = [
            'Tech Review', 'Gaming Highlights', 'Tutorial', 'Funny Moments', 
            'Daily Vlog', 'Food Review', 'Travel Diary', 'Music Cover',
            'Dance Challenge', 'Prank Video', 'Life Hacks', 'Product Review'
        ];

        for ($i = 1; $i <= $count; $i++) {
            $videos[] = [
                'aweme_id' => '7' . str_pad($i, 18, '0', STR_PAD_LEFT),
                'desc' => "🎥 {$themes[array_rand($themes)]} #{$i} by @{$username} 🔥 " . 
                         "This is sample content. Subscribe to TikTok API on RapidAPI to see real videos! " .
                         "#trending #viral #tiktok",
                'create_time' => time() - ($i * 3600 * rand(1, 48)),
                'video' => [
                    'cover' => 'https://placehold.co/405x720/667eea/ffffff?text=Video+' . $i . '+by+' . urlencode($username),
                    'duration' => rand(15, 180),
                    'play_addr' => [
                        'url_list' => [
                            'https://www.tiktok.com/@' . $username
                        ]
                    ],
                ],
                'statistics' => [
                    'play_count' => rand(10000, 5000000),
                    'digg_count' => rand(500, 500000),
                    'comment_count' => rand(50, 50000),
                    'share_count' => rand(100, 100000),
                ],
                '_username' => $username,
            ];
        }
        return $videos;
    }

    protected function getDummyProfile($username)
    {
        $colors = ['667eea', 'f093fb', '4facfe', 'fa709a', 'feca57', '48dbfb'];
        $color = $colors[array_rand($colors)];
        
        return [
            'user' => [
                'id' => 'demo_' . md5($username),
                'unique_id' => $username,
                'nickname' => ucwords(str_replace('_', ' ', $username)),
                'avatar_larger' => "https://ui-avatars.com/api/?name=" . urlencode($username) . 
                                  "&size=200&background={$color}&color=fff&bold=true",
                'signature' => "📱 Content Creator | 🎬 Demo Profile\n" .
                              "⚠️ Subscribe to TikTok API on RapidAPI to see real data",
                'follower_count' => rand(10000, 5000000),
                'following_count' => rand(100, 50000),
                'aweme_count' => rand(50, 1000),
            ]
        ];
    }

    protected function shouldUseDummyData()
    {
        return empty($this->apiKey) || $this->useDummyData;
    }

    public function getUserProfile($username)
    {
        if ($this->shouldUseDummyData()) {
            Log::info("Using dummy profile data for {$username}");
            return [
                'success' => true,
                'data' => $this->getDummyProfile($username),
                'dummy' => true,
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

                if ($statusCode === 403) {
                    $this->useDummyData = true;
                    return [
                        'success' => true,
                        'data' => $this->getDummyProfile($username),
                        'dummy' => true,
                    ];
                }

                if ($statusCode !== 200) {
                    return [
                        'success' => true,
                        'data' => $this->getDummyProfile($username),
                        'dummy' => true,
                    ];
                }

                $data = json_decode($body, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'data' => $this->getDummyProfile($username),
                        'dummy' => true,
                    ];
                }

                $userData = $data['data'] ?? $data;
                
                return [
                    'success' => true,
                    'data' => $userData,
                    'dummy' => false,
                ];
            } catch (\Exception $e) {
                Log::error("TikTok Profile Error ({$username}): " . $e->getMessage());
                
                return [
                    'success' => true,
                    'data' => $this->getDummyProfile($username),
                    'dummy' => true,
                ];
            }
        });
    }

    public function getUserVideos($username, $count = 12)
    {
        if ($this->shouldUseDummyData()) {
            Log::info("Using dummy video data for {$username}");
            return [
                'success' => true,
                'videos' => $this->getDummyVideos($username, $count),
                'user' => $this->getDummyProfile($username)['user'],
                'dummy' => true,
            ];
        }

        $cacheKey = "tiktok_videos_{$username}_{$count}";
        
        return Cache::remember($cacheKey, 1800, function() use ($username, $count) {
            try {
                $profileResponse = $this->getUserProfile($username);
                
                if ($profileResponse['dummy'] || !$profileResponse['success']) {
                    return [
                        'success' => true,
                        'videos' => $this->getDummyVideos($username, $count),
                        'user' => $this->getDummyProfile($username)['user'],
                        'dummy' => true,
                    ];
                }

                $userId = $profileResponse['data']['user']['id'] ?? null;
                
                if (!$userId) {
                    return [
                        'success' => true,
                        'videos' => $this->getDummyVideos($username, $count),
                        'user' => $this->getDummyProfile($username)['user'],
                        'dummy' => true,
                    ];
                }

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
                
                Log::info("TikTok Videos API", [
                    'username' => $username,
                    'status' => $statusCode,
                    'body_preview' => substr($body, 0, 500)
                ]);

                if ($statusCode === 403) {
                    $this->useDummyData = true;
                    return [
                        'success' => true,
                        'videos' => $this->getDummyVideos($username, $count),
                        'user' => $this->getDummyProfile($username)['user'],
                        'dummy' => true,
                    ];
                }

                if ($statusCode !== 200) {
                    return [
                        'success' => true,
                        'videos' => $this->getDummyVideos($username, $count),
                        'user' => $this->getDummyProfile($username)['user'],
                        'dummy' => true,
                    ];
                }

                $data = json_decode($body, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'videos' => $this->getDummyVideos($username, $count),
                        'user' => $this->getDummyProfile($username)['user'],
                        'dummy' => true,
                    ];
                }
                
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
                
                foreach ($videos as &$video) {
                    $video['_username'] = $username;
                }
                
                $videos = array_slice($videos, 0, $count);
                
                if (empty($videos)) {
                    Log::warning("No videos found, using dummy data");
                    return [
                        'success' => true,
                        'videos' => $this->getDummyVideos($username, $count),
                        'user' => $this->getDummyProfile($username)['user'],
                        'dummy' => true,
                    ];
                }
                
                return [
                    'success' => true,
                    'videos' => $videos,
                    'user' => $data['data']['user'] ?? $data['user'] ?? $profileResponse['data']['user'] ?? null,
                    'dummy' => false,
                ];
            } catch (\Exception $e) {
                Log::error("TikTok Videos Error: " . $e->getMessage());
                
                return [
                    'success' => true,
                    'videos' => $this->getDummyVideos($username, $count),
                    'user' => $this->getDummyProfile($username)['user'],
                    'dummy' => true,
                ];
            }
        });
    }

    public function getMultipleProfiles(array $usernames)
    {
        $profiles = [];
        
        foreach ($usernames as $username) {
            $profile = $this->getUserProfile($username);
            if ($profile['success']) {
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
                'dummy_mode' => true,
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
                    'message' => 'Subscribe at: https://rapidapi.com/DataFanatic/api/tiktok-scraper7',
                    'dummy_mode' => true,
                ];
            }

            return [
                'success' => $statusCode === 200,
                'status' => $statusCode,
                'message' => 'Connection OK',
                'dummy_mode' => false,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'dummy_mode' => true,
            ];
        }
    }
}