<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideoFeedController extends Controller
{
    protected $masterView = 'frontend.pages.video-feed';

    public function index()
    {
        return view($this->masterView);
    }
    public function userVideoFeed($username)
    {
       
        // Pass username to the view
        return view($this->masterView, compact('username'));
    }


}
