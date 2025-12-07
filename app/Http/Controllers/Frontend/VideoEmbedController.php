<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TikTokVideo;
use Illuminate\Http\Request;

class VideoEmbedController extends Controller
{
    public function embed($slug)
    {
        $data = TikTokVideo::where('slug', $slug)->orWhere('video_id', $slug)->firstOrFail();

        $video = [];
        $video['aweme_id'] = $data->aweme_id;
        $video['slug'] = $data->slug;
        $video['duration'] = $data->duration;
        $video['video_id'] = $data->video_id;
        $video['title'] = $data->title ?: $data->desc ?: 'TikTok Video';
        $video['desc'] = $data->desc;
        $video['cover'] = $data->cover;
        $video['origin_cover'] = $data->origin_cover;
        $video['dynamic_cover'] = $data->dynamic_cover;
        $video['play'] = $data->play_url;
        $video['create_time'] = strtotime($data->create_time);
        $video['play_count'] = $data->play_count;
        $video['digg_count'] = $data->digg_count;
        $video['comment_count'] = $data->comment_count;
        $video['share_count'] = $data->share_count;
        $video['author'] = [
            'unique_id' => $data->username,
            'nickname' => $data->author_nickname ?: $data->username,
            'avatar' => $data->author_avatar,
        ];
        $video['_username'] = $data->username;
        $video['thumbnail_url'] = $data->thumbnail_url;
        $video['created_at'] = $data->created_at;


        return view('frontend.video_embed', compact('video'));
    }
}
