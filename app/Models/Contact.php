<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class Contact extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'name',
        'email',
        'message',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
        'restored_at',
    ];


    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['name'] ?? null,
                fn($q, $name) =>
                $q->where('name', $name)
            );
    }
};
