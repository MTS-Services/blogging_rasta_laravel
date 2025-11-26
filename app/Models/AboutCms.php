<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCms extends Model
{
    protected $table = 'about_cms';
    protected $fillable = [
        'sort_order',
        'contact_email',
        'title_en',
        'title_fr',
        'about_us_en',
        'about_us_fr',
        'banner_video',
        'mission_title_en',
        'mission_title_fr',
        'mission_en',
        'mission_fr'
    ];
}
