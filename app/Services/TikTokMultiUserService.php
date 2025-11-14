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
        $this->client = new Client(['timeout' => 30]);
        $this->apiKey = config('tiktok.rapidapi_key');
    }

    /**
     * Get multiple users' profiles
     */
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

    /**
     * Get single user profile
     */
    public function getUserProfile($username)
    {
        $cacheKey = "tiktok_profile_{$username}";
        
        return Cache::remember($cacheKey, config('tiktok.cache_duration'), function () use ($username) {
            try {
                $response = $this->client->get($this->baseUrl . 'user/info', [
                    'headers' => [
                        'X-RapidAPI-Host' => 'tiktok-scraper7.p.rapidapi.com',
                        'X-RapidAPI-Key' => $this->apiKey,
                    ],
                    'query' => ['unique_id' => $username],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                return [
                    'success' => true,
                    'data' => $data['data'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::error("TikTok Profile Error ({$username}): " . $e->getMessage());
                return ['success' => false, 'error' => $e->getMessage()];
            }
        });
    }

    /**
     * Get videos from multiple users
     */
    public function getMultipleUsersVideos(array $usernames, $videosPerUser = 12)
    {
        $allVideos = [];
        
        foreach ($usernames as $username) {
            $result = $this->getUserVideos($username, $videosPerUser);
            
            if ($result['success'] && !empty($result['videos'])) {
                foreach ($result['videos'] as $video) {
                    // Add username to each video for reference
                    $video['_username'] = $username;
                    $allVideos[] = $video;
                }
            }
        }
        
        // Sort by create_time (newest first)
        usort($allVideos, function ($a, $b) {
            return ($b['create_time'] ?? 0) - ($a['create_time'] ?? 0);
        });
        
        return $allVideos;
    }

    /**
     * Get single user videos
     */
    public function getUserVideos($username, $count = 12)
    {
        $cacheKey = "tiktok_videos_{$username}_{$count}";
        
        return Cache::remember($cacheKey, config('tiktok.cache_duration'), function () use ($username, $count) {
            try {
                $response = $this->client->get($this->baseUrl . 'user/posts', [
                    'headers' => [
                        'X-RapidAPI-Host' => 'tiktok-scraper7.p.rapidapi.com',
                        'X-RapidAPI-Key' => $this->apiKey,
                    ],
                    'query' => [
                        'unique_id' => $username,
                        'count' => $count,
                    ],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                
                return [
                    'success' => true,
                    'videos' => $data['data']['videos'] ?? [],
                    'user' => $data['data']['user'] ?? null,
                ];
            } catch (\Exception $e) {
                Log::error("TikTok Videos Error ({$username}): " . $e->getMessage());
                return [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'videos' => [],
                ];
            }
        });
    }

    /**
     * Clear cache for specific user
     */
    public function clearUserCache($username)
    {
        Cache::forget("tiktok_profile_{$username}");
        Cache::forget("tiktok_videos_{$username}_" . config('tiktok.videos_per_user'));
    }

    /**
     * Clear all cache
     */
    public function clearAllCache()
    {
        $users = config('tiktok.featured_users');
        foreach ($users as $user) {
            $this->clearUserCache($user['username']);
        }
    }

    /**
     * Get featured users from config
     */
    public function getFeaturedUsers()
    {
        return config('tiktok.featured_users', []);
    }
}