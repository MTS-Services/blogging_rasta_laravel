<?php

namespace App\Livewire\Backend\Admin\ApplicationSettings;

use App\Livewire\Forms\Backend\Admin\ApplicationSettings;
use Livewire\Component;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Log;
use Throwable;

class DatabaseSettings extends Component
{
    public ApplicationSettings $form;
    
    public $database_settings = [];
    public $database_driver_infos = [];

    public function mount()
    {
        // Get settings from database
        $this->database_settings = ApplicationSetting::getMany([
            'database_driver', 'database_host', 'database_port', 
            'database_name', 'database_username', 'database_password'
        ]);
        
        // Load dropdown data using constants
        $this->database_driver_infos = ApplicationSetting::getDatabaseDriverInfos();
        
        // Load form data
        $this->form->database_driver = $this->database_settings['database_driver'] ?? ApplicationSetting::DATATBASE_DRIVER_MYSQL;
        $this->form->database_host = $this->database_settings['database_host'] ?? '';
        $this->form->database_port = $this->database_settings['database_port'] ?? '';
        $this->form->database_name = $this->database_settings['database_name'] ?? '';
        $this->form->database_username = $this->database_settings['database_username'] ?? '';
        $this->form->database_password = $this->database_settings['database_password'] ?? '';
    }

    public function updateSettings()
    {
        try {
            $this->form->save();

            // Refresh settings
            $this->database_settings = ApplicationSetting::getMany([
                'database_driver', 'database_host', 'database_port', 
                'database_name', 'database_username', 'database_password'
            ]);

            session()->flash('success', __('Database settings updated successfully.'));
            $this->dispatch('settings-updated');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', __('Please check the form for errors.'));
            Log::error('Database Settings Validation Error: ' . json_encode($e->errors()));
            throw $e;
        } catch (Throwable $e) {
            session()->flash('error', __('Something went wrong! Please try again.'));
            Log::error('Database Settings Update Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.application-settings.database-settings');
    }
}