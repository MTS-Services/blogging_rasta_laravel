<?php

namespace App\Livewire\Forms\Backend\Admin\ProductManagement;

use Livewire\Form;
use App\Models\Product;
use App\Enums\ProductStatus;
use Livewire\Attributes\Locked;
use App\Enums\ProductsVisibility;
use App\Enums\ProductsDeliveryMethod;

class ProducForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public string $currency = 'USD';
    public string $delivery_method = 'manual';
    public string $status = 'active';
    public string $visibility = 'public';

    public ?int $seller_id = null;
    public ?int $game_id = null;
    public ?int $product_type_id = null;
    public ?int $server_id = null;
    public ?int $reviewed_by = null;

    public float $price = 0;
    public ?float $discount_percentage = null;
    public ?float $discounted_price = null;

    public int $stock_quantity = 0;
    public int $min_purchase_quantity = 1;
    public ?int $max_purchase_quantity = null;
    public ?int $delivery_time_hours = 24;
    public int $total_sales = 0;
    public float $total_revenue = 0;
    public int $view_count = 0;
    public int $favorite_count = 0;
    public float $average_rating = 0;
    public int $total_reviews = 0;


    public bool $unlimited_stock = false;
    public bool $is_featured = false;
    public bool $is_hot_deal = false;

    public ?string $auto_delivery_content = null;
    public ?string $platform = null;
    public ?string $region = null;
    public ?string $specifications = null;
    public ?string $requirements = null;
    public ?string $reviewed_at = null;
    public ?string $rejection_reason = null;
    public ?string $meta_title = null;
    public ?string $meta_description = null;
    public ?string $meta_keywords = null;

    public $images = [];


    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'required|string|max:255|unique:products,slug,' . $this->id
            : 'required|string|max:255|unique:products,slug';

        return [

            'id' => 'nullable|integer',


            'seller_id' => 'required|integer|exists:users,id',
            'game_id' => 'required|integer|exists:games,id',
            'product_type_id' => 'required|integer|exists:product_types,id',
            'server_id' => 'nullable|integer|exists:servers,id',
            'reviewed_by' => 'nullable|integer|exists:users,id',


            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'required|string',


            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discounted_price' => 'nullable|numeric|min:0',


            'stock_quantity' => 'required|integer|min:0',
            'min_purchase_quantity' => 'required|integer|min:1',
            'max_purchase_quantity' => 'nullable|integer|min:1',
            'unlimited_stock' => 'boolean',

            'delivery_method' => 'required|string|in:' . implode(',', array_column(ProductsDeliveryMethod::cases(), 'value')),
            'delivery_time_hours' => 'nullable|integer|min:1',
            'auto_delivery_content' => 'nullable|string',

            'platform' => 'nullable|string|max:50',
            'region' => 'nullable|string|max:50',
            'specifications' => 'nullable|json',
            'requirements' => 'nullable|json',


            'status' => 'required|string|in:' . implode(',', array_column(ProductStatus::cases(), 'value')),
            'is_featured' => 'boolean',
            'is_hot_deal' => 'boolean',
            'visibility' => 'required|string|in:' . implode(',', array_column(ProductsVisibility::cases(), 'value')),


            'total_sales' => 'nullable|integer|min:0',
            'total_revenue' => 'nullable|numeric|min:0',
            'view_count' => 'nullable|integer|min:0',
            'favorite_count' => 'nullable|integer|min:0',
            'average_rating' => 'nullable|numeric|min:0|max:5',
            'total_reviews' => 'nullable|integer|min:0',


            'reviewed_at' => 'nullable|date',
            'rejection_reason' => 'nullable|string',


            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',

            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function setData(Product $product): void
    {
        $this->id = $product->id;
        $this->seller_id = $product->seller_id;
        $this->game_id = $product->game_id;
        $this->product_type_id = $product->product_type_id;
        $this->title = $product->title;
        $this->slug = $product->slug;
        $this->description = $product->description ?? '';
        $this->price = (float) $product->price;
        $this->currency = $product->currency;
        $this->discount_percentage = $product->discount_percentage ? (float) $product->discount_percentage : null;
        $this->discounted_price = $product->discounted_price ? (float) $product->discounted_price : null;
        $this->stock_quantity = (int) $product->stock_quantity;
        $this->min_purchase_quantity = (int) $product->min_purchase_quantity;
        $this->max_purchase_quantity = $product->max_purchase_quantity ? (int) $product->max_purchase_quantity : null;
        $this->unlimited_stock = (bool) $product->unlimited_stock;

        $this->delivery_method = $product->delivery_method?->value ?? ProductsDeliveryMethod::MANUAL->value;

        $this->delivery_time_hours = $product->delivery_time_hours ? (int) $product->delivery_time_hours : null;
        $this->auto_delivery_content = $product->auto_delivery_content;
        $this->server_id = $product->server_id;
        $this->platform = $product->platform;
        $this->region = $product->region;
        $this->specifications = $product->specifications;
        $this->requirements = $product->requirements;

        $this->status = $product->status?->value ?? ProductStatus::ACTIVE->value;

        $this->is_featured = (bool) $product->is_featured;
        $this->is_hot_deal = (bool) $product->is_hot_deal;

        $this->visibility = $product->visibility?->value ?? ProductsVisibility::PUBLIC->value;

        $this->total_sales = (int) $product->total_sales;
        $this->total_revenue = (float) $product->total_revenue;
        $this->view_count = (int) $product->view_count;
        $this->favorite_count = (int) $product->favorite_count;
        $this->average_rating = (float) $product->average_rating;
        $this->total_reviews = (int) $product->total_reviews;
        $this->reviewed_by = $product->reviewed_by;
        $this->reviewed_at = $product->reviewed_at;
        $this->rejection_reason = $product->rejection_reason;
        $this->meta_title = $product->meta_title;
        $this->meta_description = $product->meta_description;
        $this->meta_keywords = $product->meta_keywords;
    }

    public function reset(...$properties): void
    {
        parent::reset(...$properties);

        $this->resetValidation();


        $this->delivery_method = 'manual';
        $this->status = 'active';
        $this->visibility = 'public';
        $this->currency = 'USD';
        $this->stock_quantity = 0;
        $this->min_purchase_quantity = 1;
        $this->delivery_time_hours = 24;
        $this->unlimited_stock = false;
        $this->is_featured = false;
        $this->is_hot_deal = false;
        $this->price = 0;
        $this->total_sales = 0;
        $this->total_revenue = 0;
        $this->view_count = 0;
        $this->favorite_count = 0;
        $this->average_rating = 0;
        $this->total_reviews = 0;
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }

    public function fillables(): array
    {
        return array_filter([
            'seller_id' => $this->seller_id,
            'game_id' => $this->game_id,
            'product_type_id' => $this->product_type_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description ?: null,
            'price' => $this->price,
            'currency' => $this->currency,
            'discount_percentage' => $this->discount_percentage,
            'discounted_price' => $this->discounted_price,
            'stock_quantity' => $this->stock_quantity,
            'min_purchase_quantity' => $this->min_purchase_quantity,
            'max_purchase_quantity' => $this->max_purchase_quantity,
            'unlimited_stock' => $this->unlimited_stock,
            'delivery_method' => $this->delivery_method,
            'delivery_time_hours' => $this->delivery_time_hours,
            'auto_delivery_content' => $this->auto_delivery_content ?: null,
            'server_id' => $this->server_id,
            'platform' => $this->platform ?: null,
            'region' => $this->region ?: null,
            'specifications' => $this->specifications ?: null,
            'requirements' => $this->requirements ?: null,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'is_hot_deal' => $this->is_hot_deal,
            'visibility' => $this->visibility,
            'total_sales' => $this->total_sales,
            'total_revenue' => $this->total_revenue,
            'view_count' => $this->view_count,
            'favorite_count' => $this->favorite_count,
            'average_rating' => $this->average_rating,
            'total_reviews' => $this->total_reviews,
            'reviewed_by' => $this->reviewed_by,
            'reviewed_at' => $this->reviewed_at,
            'rejection_reason' => $this->rejection_reason ?: null,
            'meta_title' => $this->meta_title ?: null,
            'meta_description' => $this->meta_description ?: null,
            'meta_keywords' => $this->meta_keywords ?: null,
            'images' => $this->images,
        ], function ($value) {
            return $value !== '' && $value !== null;
        });
    }
}
