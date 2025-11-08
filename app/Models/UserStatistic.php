<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class UserStatistic extends BaseModel implements Auditable
{
    use  AuditableTrait;
    protected $fillable = [
        'sort_order',
        'user_id',
        'total_orders_as_buyer',
        'total_spent',
        'total_orders_as_seller',
        'total_earned',
        'average_rating_as_seller',
        'total_reviews_as_seller',
        'currency_id',

        'created_type',
        'updated_type',
        'deleted_type',
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'average_rating_as_seller' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }




    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */


    // public function scopeSearch($query, $search)
    // {
    //     return $query->where(function ($q) use ($search) {
    //         $q->where('title', 'like', "%{$search}%")
    //             ->orWhere('description', 'like', "%{$search}%");
    //     });
    // }

    public function scopeFilder($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('is_active', $status))
            ->when($filters['user_id'] ?? null, fn($q, $user_id) => $q->where('user_id', $user_id))
            ->when($filters['currency_id'] ?? null, fn($q, $currency_id) => $q->where('currency_id', $currency_id));
        return $query;
    }




    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */




    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
}
