<?php

namespace App\Http\Controllers\Backend\Admin\BannerVideo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BannerVideoService;

class BannerVideoController extends Controller
{
    protected $masterView = 'backend.admin.pages.banner-video.banner-video';

    public function __construct(protected BannerVideoService $service) {}

    /**
     * banner page index
     */
    public function index()
    {
        return view($this->masterView);
    }
}
