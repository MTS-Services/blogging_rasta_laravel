<?php

namespace App\Models;

use App\Enums\LanguageDirection;
use App\Enums\LanguageStatus;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Language extends BaseModel implements Auditable
{
    use  AuditableTrait;
    
    protected $fillable = [
        'sort_order',
        'locale',
        'name',
        'native_name',
        'flag_icon',
        'status',
        'is_active',
        'direction',


        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'status' => LanguageStatus::class,
        'is_active' => 'boolean',
        'direction' => LanguageDirection::class,
    ];


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


    public function users()
    {
        return $this->hasMany(User::class);
    }






    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', LanguageStatus::ACTIVE);
    }
    public function scopeInactive($query)
    {
        return $query->where('status', LanguageStatus::INACTIVE);
    }
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('native_name', 'like', "%{$search}%")
                ->orWhere('locale', 'like', "%{$search}%");
        });
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status));
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        return $this->status->label();
    }
    public function getStatusColorAttribute()
    {
        return $this->status->color();
    }
    public function getDractionLabelAttribute()
    {
        return $this->type->label();
    }
    public function getDractionColorAttribute()
    {
        return $this->type->color();
    }


    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
    public function isActive(): bool
    {
        return $this->status === LanguageStatus::ACTIVE;
    }
    public function activate(): void
    {
        $this->update(['status' => LanguageStatus::ACTIVE]);
    }


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
            'direction_label',
            'direction_color',
        ]);
    }
}
