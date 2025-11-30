<?php

namespace App\Models;

use App\Enums\UserCategoryStatus;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class UserCategory extends BaseModel implements Auditable
{
    use Searchable, AuditableTrait;

    protected $fillable = [
        'sort_oder',
        'title',
        'status',


        'restored_at',

        'created_by',
        'updated_by',
        'deleted_by',
        'restored_by',
    ];


    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'status' => UserCategoryStatus::class,
        'restored_at' => 'datetime',
    ];



    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function users()
    {
        return $this->hasMany(TikTokUser::class, 'user_category_id', 'id');
    }


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', UserCategoryStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', UserCategoryStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when(
                $filters['title'] ?? null,
                fn($q, $title) =>
                $q->where('title', 'like', "%{$title}%")
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'title', 'status'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
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
    |        Attribute Accessors                                    |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#= */


    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }
}
