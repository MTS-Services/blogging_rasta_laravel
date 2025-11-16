<?php

namespace App\Models;

use App\Enums\BlogStatus;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\BaseModel;

class Blog extends BaseModel implements Auditable
{
       protected $fillable = [
        'sort_order',
        'title',
        'slug',
        'status',
        'file',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'status' => BlogStatus::class,
         'meta_keywords' => 'array',
    ];

}
