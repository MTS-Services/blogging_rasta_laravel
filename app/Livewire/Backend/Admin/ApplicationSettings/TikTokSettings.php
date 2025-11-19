<?php

namespace App\Livewire\Backend\Admin\ApplicationSettings;

use App\Livewire\Forms\Backend\Admin\TikTokSettings as TikTokSettingsForm;
use Livewire\Component;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Log;
use Throwable;

class TiktokSettings extends Component
{
    public TikTokSettingsForm $form;
    
    public $tiktok_settings = [];

    public function mount()
    {
        // Get TikTok settings from database
        $this->tiktok_settings = ApplicationSetting::getMany([
            'rapidapi_key',
            'featured_users',
            'default_max_videos_per_user',
            'videos_per_page',
            'videos_per_user_per_page',
            'cache_duration'
        ]);
        
        // Load form data
        $this->form->rapidapi_key = $this->tiktok_settings['rapidapi_key'] ?? '';
        
        // Decode featured users
        $featuredUsers = json_decode($this->tiktok_settings['featured_users'] ?? '[]', true);
        $this->form->featured_users = is_array($featuredUsers) && !empty($featuredUsers) ? $featuredUsers : [];
        
        $this->form->default_max_videos_per_user = $this->tiktok_settings['default_max_videos_per_user'] ?? 20;
        $this->form->videos_per_page = $this->tiktok_settings['videos_per_page'] ?? 12;
        $this->form->videos_per_user_per_page = $this->tiktok_settings['videos_per_user_per_page'] ?? 4;
        $this->form->cache_duration = $this->tiktok_settings['cache_duration'] ?? 3600;

        // Initialize with at least one featured user if empty
        if (empty($this->form->featured_users)) {
            $this->form->featured_users = [
                [
                    'username' => '',
                    'display_name' => '',
                    'max_videos' => 20,
                ]
            ];
        }
    }

    public function addFeaturedUser()
    {
        $this->form->addFeaturedUser();
    }

    public function removeFeaturedUser($index)
    {
        $this->form->removeFeaturedUser($index);
    }

    public function updateSettings()
    {
        try {
            // Validate and save
            $this->form->save();

            // Refresh settings from database
            $this->tiktok_settings = ApplicationSetting::getMany([
                'rapidapi_key',
                'featured_users',
                'default_max_videos_per_user',
                'videos_per_page',
                'videos_per_user_per_page',
                'cache_duration'
            ]);

            // Show success message
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('TikTok settings updated successfully.')
            ]);
            
            session()->flash('success', __('TikTok settings updated successfully.'));
            $this->dispatch('tiktok-settings-updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('Please check the form for errors.')
            ]);
            
            session()->flash('error', __('Please check the form for errors.'));
            Log::error('TikTok Settings Validation Error: ' . json_encode($e->errors()));
            
            throw $e;
            
        } catch (Throwable $e) {
            // Other errors
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('Something went wrong! Please try again.')
            ]);
            
            session()->flash('error', __('Something went wrong! Please try again.'));
            Log::error('TikTok Settings Update Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.application-settings.tiktok-settings');
    }
}