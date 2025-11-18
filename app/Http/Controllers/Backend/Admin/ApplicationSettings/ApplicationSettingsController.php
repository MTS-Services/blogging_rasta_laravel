<?php

namespace App\Http\Controllers\Backend\Admin\ApplicationSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationSettingsController extends Controller
{
     protected $masterView = 'backend.admin.pages.application-settings';


    public function generalSettings()
    {
        return view($this->masterView);
    }

    public function databaseSettings()
    {
        return view($this->masterView);
    }
    public function tikTokSettings()
    {
        return view($this->masterView);
    }
    
}
