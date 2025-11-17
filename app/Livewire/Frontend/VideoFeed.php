<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\TikTokMultiUserService;
use Illuminate\Support\Facades\Log;

class VideoFeed extends Component
{
    public $activeUser = 'All';
    public $videos = [];
    public $loading = true;
    public $error = null;

    protected $tiktokService;

    public function boot(TikTokMultiUserService $tiktokService)
    {
        $this->tiktokService = $tiktokService;
    }

    public function mount()
    {
        $this->loadVideos();
    }

    public function loadVideos()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Get featured users from config
            $featuredUsers = config('tiktok.featured_users', []);
            $usernames = array_column($featuredUsers, 'username');

            if (empty($usernames)) {
                throw new \Exception('No featured users configured');
            }

            // Load videos from TikTok API (increased limit for video feed page)
            $this->videos = $this->tiktokService->getMultipleUsersVideos($usernames, 15);

            Log::info('VideoFeed page - TikTok videos loaded', [
                'count' => count($this->videos),
                'users' => $usernames
            ]);
        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('VideoFeed page - TikTok loading failed', [
                'error' => $e->getMessage()
            ]);
            $this->videos = [];
        }

        $this->loading = false;
    }

    public function setUser($username)
    {
        $this->activeUser = $username;
    }

    public function getUsersProperty()
    {
        $featuredUsers = config('tiktok.featured_users', []);
        $users = ['All'];
        
        foreach ($featuredUsers as $user) {
            $users[] = $user['username'];
        }
        
        return $users;
    }

    public function getFilteredVideosProperty()
    {
        if ($this->activeUser === 'All') {
            return $this->videos;
        }

        return collect($this->videos)
            ->filter(function ($video) {
                $username = $video['_username'] ?? ($video['author']['unique_id'] ?? '');
                return $username === $this->activeUser;
            })
            ->values()
            ->toArray();
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

    public function render()
    {
        return view('livewire.frontend.video-feed', [
            'filteredVideos' => $this->filtered_videos,
            'users' => $this->users,
        ]);
    }
}