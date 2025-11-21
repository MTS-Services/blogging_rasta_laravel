<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Services\AdminService;
use App\Services\ProductService;
use App\Models\TikTokVideo;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $stats = [];
    public $tiktokUsers = [];

    public function mount(AdminService $adminService, ProductService $productService)
    {
        // Get counts for dashboard
        $this->stats = [
            'total_users' => $adminService->getDataCount(),
            'active_users' => $adminService->getActiveData()->count(),
            'inactive_users' => $adminService->getInactiveData()->count(),
            
            'total_products' => $productService->getDataCount(),
            'active_products' => $productService->getActiveData()->count(),
            'inactive_products' => $productService->getInactiveData()->count(),
            
            'total_videos' => TikTokVideo::count(),
            'active_videos' => TikTokVideo::where('is_active', true)->count(),
            'inactive_videos' => TikTokVideo::where('is_active', false)->count(),
            'featured_videos' => TikTokVideo::where('is_featured', true)->count(),
        ];

        // Get TikTok users and their video counts
        $this->loadTikTokUsers();
    }

    private function loadTikTokUsers()
    {
        try {
            // Get featured users from config
            $tiktokConfig = ApplicationSetting::getTikTokConfig();
            $featuredUsers = $tiktokConfig['featured_users'] ?? [];

            // Get video counts per user from database
            $userVideoCounts = TikTokVideo::select('username', DB::raw('count(*) as total_videos'))
                ->whereNotNull('username')
                ->groupBy('username')
                ->get()
                ->keyBy('username');

            // Prepare user data with counts
            $this->tiktokUsers = collect($featuredUsers)->map(function($user) use ($userVideoCounts) {
                $username = $user['username'] ?? $user;
                $videoCount = $userVideoCounts->get($username)?->total_videos ?? 0;

                return [
                    'username' => $username,
                    'max_videos' => $user['max_videos'] ?? 12,
                    'total_videos' => $videoCount,
                    'active_videos' => TikTokVideo::where('username', $username)->where('is_active', true)->count(),
                    'featured_videos' => TikTokVideo::where('username', $username)->where('is_featured', true)->count(),
                ];
            })->toArray();

            // Add total users count to stats
            $this->stats['total_tiktok_users'] = count($featuredUsers);

        } catch (\Exception $e) {
            $this->tiktokUsers = [];
            $this->stats['total_tiktok_users'] = 0;
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.dashboard');
    }
}