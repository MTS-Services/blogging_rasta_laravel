<?php

namespace App\Http\Controllers\Backend\Admin\TikTokManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TikTokMixedFeedController extends Controller
{
      protected $masterView = 'backend.admin.pages.tiktok-management.tiktok-mixed-feed';

    public function index()
    {
        return view($this->masterView);
    }
}
