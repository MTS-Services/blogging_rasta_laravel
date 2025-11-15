<?php

namespace App\Livewire\Backend\Admin\TikTokManagement;

use Livewire\Component;
use App\Services\TikTokMultiUserService;
use Illuminate\Support\Facades\Log;

class TikTokMixedFeed extends Component
{
    public $videos = [];
    public $profiles = [];
    public $featuredUsers = [];
    public $loading = true;
    public $error = null;
    public $selectedUser = 'all';
    public $debugInfo = [];
    public $showDebug = false; // Toggle for debug panel

    protected $service;

    public function boot(TikTokMultiUserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->featuredUsers = $this->service->getFeaturedUsers();

        if (empty(config('tiktok.rapidapi_key'))) {
            $this->error = 'RapidAPI key is not configured. Please set RAPIDAPI_KEY in your .env file.';
            $this->loading = false;
            return;
        }

        $this->loadData();
    }

    public function loadData()
    {
        $this->loading = true;
        $this->error = null;
        $this->debugInfo = [];

        try {
            // Test API connection first
            $connectionTest = $this->service->testConnection();
            $this->debugInfo['connection_test'] = $connectionTest;

            Log::info('API Connection Test', $connectionTest);

            if (!$connectionTest['success']) {
                throw new \Exception('API connection failed: ' . ($connectionTest['error'] ?? 'Unknown error'));
            }

            $usernames = array_column($this->featuredUsers, 'username');

            Log::info('Loading TikTok data for users', ['usernames' => $usernames]);

            // Load profiles with detailed debugging
            $this->profiles = $this->service->getMultipleProfiles($usernames);
            $this->debugInfo['profiles_count'] = count($this->profiles);
            $this->debugInfo['profiles_data'] = [];

            // Debug each profile
            foreach ($this->profiles as $username => $profileData) {
                $userInfo = $profileData['user'] ?? null;
                
                $this->debugInfo['profiles_data'][$username] = [
                    'raw_structure' => array_keys($profileData),
                    'has_user_key' => isset($profileData['user']),
                    'user_info' => $userInfo ? [
                        'id' => $userInfo['id'] ?? 'N/A',
                        'unique_id' => $userInfo['unique_id'] ?? 'N/A',
                        'nickname' => $userInfo['nickname'] ?? 'N/A',
                        'avatar_larger' => $userInfo['avatar_larger'] ?? 'N/A',
                        'avatar_thumb' => $userInfo['avatar_thumb'] ?? 'N/A',
                        'avatar' => $userInfo['avatar'] ?? 'N/A',
                        'signature' => $userInfo['signature'] ?? 'N/A',
                        'follower_count' => $userInfo['follower_count'] ?? 0,
                        'following_count' => $userInfo['following_count'] ?? 0,
                        'aweme_count' => $userInfo['aweme_count'] ?? 0,
                        'total_favorited' => $userInfo['total_favorited'] ?? 0,
                        'verified' => $userInfo['verified'] ?? false,
                    ] : 'User info not found',
                ];

                Log::info("Profile loaded for {$username}", [
                    'structure' => array_keys($profileData),
                    'has_user' => isset($profileData['user']),
                    'user_fields' => $userInfo ? array_keys($userInfo) : []
                ]);
            }

            // Load videos with detailed debugging
            $videosPerUser = config('tiktok.videos_per_user', 12);
            $this->videos = $this->service->getMultipleUsersVideos($usernames, $videosPerUser);
            $this->debugInfo['videos_count'] = count($this->videos);
            $this->debugInfo['videos_data'] = [];

            // Debug first 3 videos in detail
            foreach (array_slice($this->videos, 0, 3) as $index => $video) {
                $this->debugInfo['videos_data']['video_' . ($index + 1)] = [
                    'raw_structure' => array_keys($video),
                    'aweme_id' => $video['aweme_id'] ?? 'N/A',
                    'desc' => substr($video['desc'] ?? 'N/A', 0, 100) . '...',
                    'create_time' => $video['create_time'] ?? 'N/A',
                    'username' => $video['_username'] ?? 'N/A',
                    'video_structure' => isset($video['video']) ? array_keys($video['video']) : 'N/A',
                    'video_cover' => $video['video']['cover'] ?? 'N/A',
                    'video_duration' => $video['video']['duration'] ?? 'N/A',
                    'play_addr_available' => isset($video['video']['play_addr']['url_list'][0]),
                    'statistics' => $video['statistics'] ?? $video['stats'] ?? 'N/A',
                ];
            }

            Log::info('TikTok data loaded successfully', [
                'profiles' => count($this->profiles),
                'videos' => count($this->videos),
                'videos_by_user' => array_count_values(array_column($this->videos, '_username'))
            ]);

            // Log full structure of first profile
            if (!empty($this->profiles)) {
                $firstProfile = reset($this->profiles);
                Log::info('First Profile Full Structure', [
                    'data' => $firstProfile
                ]);
            }

            // Log full structure of first video
            if (!empty($this->videos)) {
                Log::info('First Video Full Structure', [
                    'data' => $this->videos[0]
                ]);
            }

            if (empty($this->videos)) {
                $this->error = 'No videos found. API returned no data. Check logs for details.';
            }
        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            $this->debugInfo['error'] = $e->getMessage();
            $this->debugInfo['trace'] = $e->getTraceAsString();

            Log::error('TikTok data loading failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        $this->loading = false;
    }

    public function toggleDebug()
    {
        $this->showDebug = !$this->showDebug;
    }

    public function filterByUser($username)
    {
        $this->selectedUser = $username;
    }

    public function getFilteredVideosProperty()
    {
        if ($this->selectedUser === 'all') {
            return $this->videos;
        }

        return array_values(array_filter($this->videos, function ($video) {
            return ($video['_username'] ?? '') === $this->selectedUser;
        }));
    }

    public function refresh()
    {
        $this->service->clearAllCache();
        $this->loadData();
        session()->flash('message', 'Cache cleared and data refreshed successfully!');
    }

    public function formatNumber($number)
    {
        if (!is_numeric($number)) {
            return '0';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } else if ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return number_format($number);
    }

    public function showDebugInfo()
    {
        return !empty($this->debugInfo);
    }

    // Get detailed profile debug info for a specific user
    public function getProfileDebug($username)
    {
        return $this->debugInfo['profiles_data'][$username] ?? null;
    }

    // Get summary statistics
    public function getStatsSummary()
    {
        $stats = [
            'total_profiles' => count($this->profiles),
            'total_videos' => count($this->videos),
            'videos_by_user' => [],
            'avg_video_duration' => 0,
            'total_views' => 0,
            'total_likes' => 0,
        ];

        // Videos per user
        foreach ($this->videos as $video) {
            $username = $video['_username'] ?? 'unknown';
            $stats['videos_by_user'][$username] = ($stats['videos_by_user'][$username] ?? 0) + 1;
            
            // Calculate averages
            $duration = $video['video']['duration'] ?? 0;
            $stats['avg_video_duration'] += $duration;
            
            $videoStats = $video['statistics'] ?? $video['stats'] ?? [];
            $stats['total_views'] += $videoStats['play_count'] ?? $videoStats['playCount'] ?? 0;
            $stats['total_likes'] += $videoStats['digg_count'] ?? $videoStats['diggCount'] ?? 0;
        }

        if (count($this->videos) > 0) {
            $stats['avg_video_duration'] = round($stats['avg_video_duration'] / count($this->videos));
        }

        return $stats;
    }

    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.tik-tok-mixed-feed', [
            'filteredVideos' => $this->getFilteredVideosProperty(),
            'statsSummary' => $this->getStatsSummary(),
        ]);
    }
}