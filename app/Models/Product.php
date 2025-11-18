<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Laravel\Scout\Searchable;
use App\Traits\AuditableTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Product extends BaseModel implements Auditable
{
    use Searchable, AuditableTrait;

    protected $fillable = [
        'sort_order',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'sale_price',
        'product_types',
        'image',
        'affiliate_link',
        'affiliate_source',
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
        'product_types' => 'array', 
        'status' => ProductStatus::class,
        'restored_at' => 'datetime',
        // 'exchange_rate' => 'decimal:15,2',
        // 'decimal_places' => 'integer',
    ];


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ProductStatus::ACTIVE);
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', ProductStatus::INACTIVE);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['title'] ?? null,
                fn($q, $title) =>
                $q->where('title', 'like', "%{$title}%")
            )
            ->when(
                $filters['category_id'] ?? null,
                fn($q, $category_id) =>
                $q->where('category_id', $category_id)
            )
            ->when(
                $filters['price'] ?? null,
                fn($q, $price) =>
                $q->where('price', $price)
            )
            ->when(
                $filters['status'] ?? null,
                fn($q, $status) =>
                $q->where('status', $status)
            );
    }

    /* ================================================================
     |  Query Scopes
     ================================================================ */

    /* ================================================================
     |  Scout Search Configuration
     ================================================================ */

    #[SearchUsingPrefix(['id', 'title', 'status', 'category_id', 'slug', 'description', 'price', 'sale_price', 'product_types', 'affiliate_link', 'affiliate_source'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'category_id' => $this->category_id,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'product_types' => $this->product_types,
            'affiliate_link' => $this->affiliate_link,
            'affiliate_source' => $this->affiliate_source,
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


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
        ]);
    }
}
