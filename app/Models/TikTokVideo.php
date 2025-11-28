<?php

namespace App\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // public function videoKeywords(): HasMany
    // {
    //     return $this->hasMany(VideoKeyword::class,'tik_tok_video_id','id');
    // }

    public function videoKeywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'video_keywords', 'tik_tok_video_id', 'keyword_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get only featured videos
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get videos by username
     */
    public function scopeByUsername($query, $username)
    {
        return $query->where('username', $username);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'desc')
            ->orderBy('create_time', 'desc');
    }

    /**
     * Get formatted play count
     */
    public function getFormattedPlayCountAttribute()
    {
        return $this->formatNumber($this->play_count);
    }

    /**
     * Get formatted digg count
     */
    public function getFormattedDiggCountAttribute()
    {
        return $this->formatNumber($this->digg_count);
    }

    /**
     * Get formatted comment count
     */
    public function getFormattedCommentCountAttribute()
    {
        return $this->formatNumber($this->comment_count);
    }

    /**
     * Format number helper
     */
    private function formatNumber($number)
    {
        if (!is_numeric($number)) {
            return '0';
        }

        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }

        return number_format($number);
    }

}
