<?php

namespace App\Models;


use App\Models\BaseModel;

class TikTokVideo extends BaseModel
{

    protected $table = 'tik_tok_videos';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'sort_order',
        'aweme_id',
        'video_id',
        'sync_at',
        'title',
        'desc',
        'play_url',
        'cover',
        'origin_cover',
        'dynamic_cover',
        'play_count',
        'digg_count',
        'comment_count',
        'share_count',
        'username',
        'author_name',
        'author_nickname',
        'author_avatar',
        'author_avatar_medium',
        'author_avatar_larger',
        'hashtags',
        'create_time',
        'duration',
        'video_format',
        'is_featured',
        'is_active',
        'music_title',
        'music_author',
        'video_description',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'hashtags' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sync_at' => 'datetime',
        'create_time' => 'datetime',
    ];

}
