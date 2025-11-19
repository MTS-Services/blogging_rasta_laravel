<?php

namespace App\Livewire\Forms\Backend\Admin;

use Livewire\Form;
use App\Models\ApplicationSetting;

class TikTokSettings extends Form
{
    public $rapidapi_key = '';
    public $featured_users = [];
    public $default_max_videos_per_user = 20;
    public $videos_per_page = 12;
    public $videos_per_user_per_page = 4;
    public $cache_duration = 3600;

    public function rules(): array
    {
        return [
            'rapidapi_key' => 'required|string|max:255',
            'featured_users' => 'required|array|min:1',
            'featured_users.*.username' => 'required|string|max:255',
            'featured_users.*.display_name' => 'required|string|max:255',
            'featured_users.*.max_videos' => 'required|integer|min:1|max:100',
            'default_max_videos_per_user' => 'required|integer|min:1|max:100',
            'videos_per_page' => 'required|integer|min:1|max:50',
            'videos_per_user_per_page' => 'required|integer|min:1|max:20',
            'cache_duration' => 'required|integer|min:60|max:86400',
        ];
    }

    public function messages(): array
    {
        return [
            'rapidapi_key.required' => 'RapidAPI Key is required.',
            'featured_users.required' => 'At least one featured user is required.',
            'featured_users.min' => 'At least one featured user is required.',
            'featured_users.*.username.required' => 'Username is required.',
            'featured_users.*.display_name.required' => 'Display name is required.',
            'featured_users.*.max_videos.required' => 'Max videos is required.',
            'featured_users.*.max_videos.min' => 'Max videos must be at least 1.',
            'featured_users.*.max_videos.max' => 'Max videos cannot exceed 100.',
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
            'max_videos' => $this->default_max_videos_per_user ?? 20,
        ];
        
        // Force re-index to ensure Livewire detects the change
        $this->featured_users = array_values($this->featured_users);
    }

    public function removeFeaturedUser($index)
    {
        // Only remove if more than one user exists
        if (count($this->featured_users) > 1) {
            unset($this->featured_users[$index]);
            // Re-index array to prevent gaps
            $this->featured_users = array_values($this->featured_users);
        }
    }
}