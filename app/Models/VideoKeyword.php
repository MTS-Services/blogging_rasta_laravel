<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoKeyword extends Model
{
     protected $fillable = [
        'tik_tok_video_id',
        'keyword_id',
    ];

    /**
     * Relation with TikTokVideo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(TikTokVideo::class, 'tik_tok_video_id','id');
    }

    /**
     * Relation with Keyword
     */
    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class, 'keyword_id','id');
    }
}
