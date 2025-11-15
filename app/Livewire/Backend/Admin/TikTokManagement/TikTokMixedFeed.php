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
    public $selectedUser = 'all'; // Filter by user
    public $debugInfo = []; // Add debug information

    protected $service;

    public function boot(TikTokMultiUserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->featuredUsers = $this->service->getFeaturedUsers();

        // Check if API key is configured
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

            if (!$connectionTest['success']) {
                throw new \Exception('API connection failed: ' . ($connectionTest['error'] ?? 'Unknown error'));
            }

            $usernames = array_column($this->featuredUsers, 'username');

            Log::info('Loading TikTok data for users', ['usernames' => $usernames]);

            // Load profiles
            $this->profiles = $this->service->getMultipleProfiles($usernames);
            $this->debugInfo['profiles_loaded'] = count($this->profiles);

            // Load videos
            $videosPerUser = config('tiktok.videos_per_user', 12);
            $this->videos = $this->service->getMultipleUsersVideos($usernames, $videosPerUser);
            $this->debugInfo['videos_loaded'] = count($this->videos);

            Log::info('TikTok data loaded successfully', [
                'profiles' => count($this->profiles),
                'videos' => count($this->videos)
            ]);

          
            if (empty($this->videos)) {
                $this->error = 'No videos found. API returned no data. Check logs.';
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

    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.tik-tok-mixed-feed', [
            'filteredVideos' => $this->getFilteredVideosProperty(),
        ]);
    }
}
