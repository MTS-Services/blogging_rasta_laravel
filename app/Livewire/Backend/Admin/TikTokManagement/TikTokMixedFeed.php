<?php

namespace App\Livewire\Backend\Admin\TikTokManagement;


use Livewire\Component;
use App\Services\TikTokMultiUserService;

class TikTokMixedFeed extends Component
{
    public $videos = [];
    public $profiles = [];
    public $featuredUsers = [];
    public $loading = true;
    public $error = null;
    public $selectedUser = 'all'; // Filter by user

    protected $service;

    public function boot(TikTokMultiUserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->featuredUsers = $this->service->getFeaturedUsers();
        $this->loadData();
    }

    public function loadData()
    {
        $this->loading = true;
        $this->error = null;

        try {
            $usernames = array_column($this->featuredUsers, 'username');
            
            // Load profiles
            $this->profiles = $this->service->getMultipleProfiles($usernames);
            
            // Load videos
            $videosPerUser = config('tiktok.videos_per_user', 12);
            $this->videos = $this->service->getMultipleUsersVideos($usernames, $videosPerUser);
            
        } catch (\Exception $e) {
            $this->error = 'ভিডিও লোড করতে সমস্যা হয়েছে: ' . $e->getMessage();
        }

        $this->loading = false;
    }

    public function filterByUser($username)
    {
        $this->selectedUser = $username;
    }

    public function getFilteredVideos()
    {
        if ($this->selectedUser === 'all') {
            return $this->videos;
        }
        
        return array_filter($this->videos, function ($video) {
            return ($video['_username'] ?? '') === $this->selectedUser;
        });
    }

    public function refresh()
    {
        $this->service->clearAllCache();
        $this->loadData();
    }

    public function formatNumber($number)
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } else if ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return number_format($number);
    }

    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.tik-tok-mixed-feed', [
            'filteredVideos' => $this->getFilteredVideos(),
        ]);
    }
}
