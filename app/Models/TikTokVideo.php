<?php

namespace App\Models;


use App\Models\BaseModel;
use App\Services\SitemapService;
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
        'slug',
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
        'thumbnail_url',
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'thumbnail_url',
            'video_title',
            'video_description_text',
            'canonical_url',
        ]);
    }


    public static function generateSlug($title, $videoId)
    {
        $slug = \Illuminate\Support\Str::slug($title);

        // If slug is empty (title was empty), use video ID
        if (empty($slug)) {
            $slug = 'diodioglow-' . $videoId;
        }

        // Ensure uniqueness
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }


    protected static function booted()
    {
        static::updated(function ($model) {
            app(SitemapService::class)->generate();
        });

        static::deleted(function ($model) {
            app(SitemapService::class)->generate();
        });
    }


    public function getRouteKeyName(): string
    {
        return 'video_id';
    }

    public function getThumbnailUrlAttribute(): string
    {
        $thumbnail = $this->getRawOriginal('thumbnail_url');

        // Priority 1: Local stored thumbnail (not from TikTok CDN)
        if ($thumbnail && !str_contains($thumbnail, 'tiktokcdn')) {
            return $thumbnail;
        }

        // Priority 2: Use image proxy for TikTok CDN URLs
        // if ($this->origin_cover) {
        //     return route('image.proxy', ['url' => $this->origin_cover]);
        // }

        // if ($this->cover) {
        //     return route('image.proxy', ['url' => $this->cover]);
        // }

        // Priority 3: Fallback to default
        return asset('assets/images/default_thumb.jpg');
    }

    public function getVideoTitleAttribute(): string
    {
        return $this->title
            ?? $this->desc
            ?? $this->video_description
            ?? "TikTok Video by {$this->author_nickname}";
    }

    public function getVideoDescriptionTextAttribute(): string
    {
        $desc = $this->video_description
            ?? $this->desc
            ?? $this->title
            ?? '';

        return strip_tags($desc);
    }

    public function getCanonicalUrlAttribute(): string
    {
        return route('video.details', $this->video_id);
    }

    // public function getSchemaMarkup(): string
    // {
    //     $schema = Schema::videoObject()
    //         ->name($this->video_title)
    //         ->description($this->video_description_text)
    //         ->thumbnailUrl($this->thumbnail)
    //         ->uploadDate($this->create_time?->toIso8601String() ?? $this->created_at->toIso8601String())
    //         ->duration("PT{$this->duration}S")
    //         ->contentUrl($this->play_url)
    //         ->embedUrl($this->canonical_url)
    //         ->interactionStatistic([
    //             Schema::interactionCounter()
    //                 ->interactionType('https://schema.org/WatchAction')
    //                 ->userInteractionCount($this->play_count),
    //             Schema::interactionCounter()
    //                 ->interactionType('https://schema.org/LikeAction')
    //                 ->userInteractionCount($this->digg_count),
    //             Schema::interactionCounter()
    //                 ->interactionType('https://schema.org/CommentAction')
    //                 ->userInteractionCount($this->comment_count),
    //         ]);

    //     if ($this->author_nickname) {
    //         $schema->author(
    //             Schema::person()
    //                 ->name($this->author_nickname)
    //                 ->url("https://www.tiktok.com/@{$this->username}")
    //         );
    //     }

    //     if (!empty($this->hashtags)) {
    //         $schema->keywords(implode(', ', $this->hashtags));
    //     }

    //     return $schema->toScript();
    // }


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
