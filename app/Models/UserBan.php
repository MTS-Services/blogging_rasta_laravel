<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\UserBanType;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;

class UserBan extends BaseModel implements Auditable
{
    use   AuditableTrait, Searchable;
    //

    protected $fillable = [
        'sort_order',
        'user_id',
        'banned_by',
        'reason',
        'type',
        'expires_at',
        'unbanned_by',
        'unbanned_at',
        'unban_reason',
        //here AuditColumns 



    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'type' => UserBanType::class
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bannedBy()
    {
        return $this->belongsTo(Admin::class, 'banned_by', 'id');
    }

    public function unbannedBy()
    {
        return $this->belongsTo(Admin::class, 'unbanned_by', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    /* ================================================================
     |  Query Scopes
     ================================================================ */



    public function scopeTemporary(Builder $query): Builder
    {
        return $query->where('type', UserBanType::TEMPORARY);
    }
    public function scopePermanent(Builder $query): Builder
    {
        return $query->where('type', UserBanType::PERMANENT);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['type'] ?? null,
                fn($q, $type) =>
                $q->where('type', $type)

            )
            ->when(
                $filters['user_id'] ?? null,
                fn($q, $user_id) =>
                $q->where('user_id', $user_id)

            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
