<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TikTokVideo;
use Illuminate\Http\Request;

class VideoDetailsController extends Controller
{
    protected $masterView = 'frontend.pages.video-details';

    public function index($id)
    {

        $video = TikTokVideo::where('video_id', $id)->firstOrFail();
        return view($this->masterView, [
            'data' => $video,
        ]);
    }
}
