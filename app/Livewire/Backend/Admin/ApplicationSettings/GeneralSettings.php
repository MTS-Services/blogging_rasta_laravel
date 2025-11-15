<?php

namespace App\Livewire\Backend\Admin\ApplicationSettings;

use App\Livewire\Forms\Backend\Admin\ApplicationSettings;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Log;
use Throwable;

class GeneralSettings extends Component
{
    use WithFileUploads;

    public ApplicationSettings $form;
    
    public $timezones = [];
    public $general_settings = [];

    public function mount()
    {
        // Get settings from database
        $this->general_settings = ApplicationSetting::getMany([
            'app_name', 'short_name', 'timezone', 'date_format', 
            'time_format', 'theme_mode', 'app_logo', 'favicon', 
            'public_registration', 'registration_approval', 
            'environment', 'app_debug', 'debugbar'
        ]);
        
        $this->timezones = availableTimezones();
        
        // Load form data
        $this->form->app_name = $this->general_settings['app_name'] ?? '';
        $this->form->short_name = $this->general_settings['short_name'] ?? '';
        $this->form->timezone = $this->general_settings['timezone'] ?? '';
        $this->form->date_format = $this->general_settings['date_format'] ?? ApplicationSetting::DATE_FORMAT_ONE;
        $this->form->time_format = $this->general_settings['time_format'] ?? ApplicationSetting::TIME_FORMAT_24;
        $this->form->theme_mode = $this->general_settings['theme_mode'] ?? ApplicationSetting::THEME_MODE_SYSTEM;
        $this->form->public_registration = $this->general_settings['public_registration'] ?? ApplicationSetting::ALLOW_PUBLIC_REGISTRATION;
        $this->form->registration_approval = $this->general_settings['registration_approval'] ?? ApplicationSetting::REGISTRATION_APPROVAL_AUTO;
        $this->form->environment = $this->general_settings['environment'] ?? ApplicationSetting::ENVIRONMENT_DEVELOPMENT;
        $this->form->app_debug = $this->general_settings['app_debug'] ?? ApplicationSetting::APP_DEBUG_FALSE;
        $this->form->debugbar = $this->general_settings['debugbar'] ?? ApplicationSetting::DISABLE_DEBUGBAR;
    }

    public function updateSettings()
    {
        try {
            $this->form->save();

            // Refresh settings
            $this->general_settings = ApplicationSetting::getMany([
                'app_name', 'short_name', 'timezone', 'date_format', 
                'time_format', 'theme_mode', 'app_logo', 'favicon', 
                'public_registration', 'registration_approval', 
                'environment', 'app_debug', 'debugbar'
            ]);

            session()->flash('success', __('Settings updated successfully.'));
            $this->dispatch('settings-updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', __('Please check the form for errors.'));
            Log::error('Settings Validation Error: ' . json_encode($e->errors()));
            throw $e;
        } catch (Throwable $e) {
            session()->flash('error', __('Something went wrong! Please try again.'));
            Log::error('Settings Update Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.application-settings.general-settings');
    }
}
