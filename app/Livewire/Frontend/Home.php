<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Services\TikTokMultiUserService;
use Illuminate\Support\Facades\Log;

class Home extends Component
{
    public $input;
    public $email;
    public $password;
    public $disabled;

    public $standardSelect;
    public $disabledSelect;
    public $select2Single;
    public $select2Multiple;

    public $featuredVideos = [];
    public $hashtags;
    public $loading = true;
    public $error = null;

    protected $service;

    public function boot(TikTokMultiUserService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
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

            // Load videos from TikTok API (limit to 12 videos for home page)
            $this->featuredVideos = $this->service->getMultipleUsersVideos($usernames, 8);

            // Limit to 12 videos for home page display
            $this->featuredVideos = array_slice($this->featuredVideos, 0, 12);

            // Debug: Log first video structure to understand data format
            if (!empty($this->featuredVideos)) {
                Log::info('Home page - First video structure', [
                    'video_keys' => array_keys($this->featuredVideos[0]),
                    'has_statistics' => isset($this->featuredVideos[0]['statistics']),
                    'has_stats' => isset($this->featuredVideos[0]['stats']),
                    'statistics_data' => $this->featuredVideos[0]['statistics'] ?? null,
                    'stats_data' => $this->featuredVideos[0]['stats'] ?? null,
                ]);
            }

            Log::info('Home page TikTok videos loaded', [
                'count' => count($this->featuredVideos)
            ]);

        } catch (\Exception $e) {
            $this->error = 'Failed to load videos: ' . $e->getMessage();
            Log::error('Home page TikTok loading failed', [
                'error' => $e->getMessage()
            ]);
            
            // Set empty array if failed
            $this->featuredVideos = [];
        }

        // Load hashtags (keep static for now)
        $this->hashtags = [
            ['tag' => '#GlowSkin', 'videos' => '48'],
            ['tag' => '#DiodioTips', 'videos' => '32'],
            ['tag' => '#NaturalBeauty', 'videos' => '125'],
            ['tag' => '#SkincareRoutine', 'videos' => '95'],
            ['tag' => '#BeautyHaul', 'videos' => '72'],
            ['tag' => '#SkincareTips', 'videos' => '156'],
        ];

        $this->loading = false;
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

    public $content = '<p>This is the initial content of the editor.</p>';

    public function saveContent()
    {
        dd($this->content);
    }

    public function saveContent2()
    {
        dd($this->content);
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}