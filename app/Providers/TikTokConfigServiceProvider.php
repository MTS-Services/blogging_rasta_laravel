<?php
// app/Providers/TikTokConfigServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Log;

class TikTokConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // যদি console command হয় (migrate, seed etc) তাহলে skip করুন
        if ($this->app->runningInConsole()) {
            return;
        }

        try {
            // Database থেকে config load করুন
            $tiktokConfig = ApplicationSetting::getTikTokConfig();
            
            // Config merge করুন
            config([
                'tiktok.rapidapi_key' => $tiktokConfig['rapidapi_key'],
                'tiktok.featured_users' => $tiktokConfig['featured_users'],
                'tiktok.default_max_videos_per_user' => $tiktokConfig['default_max_videos_per_user'],
                'tiktok.videos_per_page' => $tiktokConfig['videos_per_page'],
                'tiktok.videos_per_user_per_page' => $tiktokConfig['videos_per_user_per_page'],
                'tiktok.cache_duration' => $tiktokConfig['cache_duration'],
            ]);
        } catch (\Exception $e) {
            // Database connection issue হলে default config ব্যবহার হবে
            Log::warning('Could not load TikTok config from database: ' . $e->getMessage());
        }
    }
}