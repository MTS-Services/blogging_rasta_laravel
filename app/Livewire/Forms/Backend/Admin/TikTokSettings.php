<?php

namespace App\Livewire\Forms\Backend\Admin;

use Livewire\Form;
use App\Models\ApplicationSetting;

class TikTokSettings extends Form
{
    public $rapidapi_key;
    public $featured_users = [];
    public $default_max_videos_per_user;
    public $videos_per_page;
    public $videos_per_user_per_page;
    public $cache_duration;

    public function rules(): array
    {
        return [
            'rapidapi_key' => 'required|string|max:255',
            'featured_users' => 'nullable|array',
            'featured_users.*.username' => 'required|string|max:255',
            'featured_users.*.display_name' => 'required|string|max:255',
            'featured_users.*.max_videos' => 'required|integer|min:1|max:100',
            'default_max_videos_per_user' => 'required|integer|min:1|max:100',
            'videos_per_page' => 'required|integer|min:1|max:50',
            'videos_per_user_per_page' => 'required|integer|min:1|max:20',
            'cache_duration' => 'required|integer|min:60|max:86400',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        // Save RapidAPI Key
        ApplicationSetting::set('rapidapi_key', $validated['rapidapi_key'], 'RAPIDAPI_KEY');

        // Save Featured Users as JSON
        $featuredUsers = $validated['featured_users'] ?? [];
        ApplicationSetting::set('featured_users', json_encode($featuredUsers), null);

        // Save other TikTok settings
        ApplicationSetting::set('default_max_videos_per_user', $validated['default_max_videos_per_user'], null);
        ApplicationSetting::set('videos_per_page', $validated['videos_per_page'], null);
        ApplicationSetting::set('videos_per_user_per_page', $validated['videos_per_user_per_page'], null);
        ApplicationSetting::set('cache_duration', $validated['cache_duration'], null);

        // Clear all settings cache
        ApplicationSetting::clearCache();
    }

    public function addFeaturedUser()
    {
        $this->featured_users[] = [
            'username' => '',
            'display_name' => '',
            'max_videos' => 20,
        ];
    }

    public function removeFeaturedUser($index)
    {
        unset($this->featured_users[$index]);
        $this->featured_users = array_values($this->featured_users);
    }
}