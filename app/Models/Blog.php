<?php

namespace App\Models;

use App\Enums\BlogStatus;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Illuminate\Database\Eloquent\Builder;

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

        'restored_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
    ];

    protected $casts = [
        'status' => BlogStatus::class,
         'meta_keywords' => 'array',
    ];

      /* =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |           Query Scopes                                       |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#= */

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['code'] ?? null,
                fn($q, $code) =>
                $q->where('code', 'like', "%{$code}%")
            )
            ->when(
                $filters['is_default'] ?? null,
                fn($q, $isDefault) =>
                $q->where('is_default', $isDefault)
            );
    }

    /*  =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |          End of Query Scopes                                   |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#= */

    
    /* =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |          Scout Search Configuration                         |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#= */

    #[SearchUsingPrefix(['name', 'email', 'phone', 'status'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }

    /* =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |        End  Scout Search Configuration                                    |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#= */



}
