<?php

namespace App\Livewire\Forms\Product;

use Livewire\Form;

use App\Enums\ProductStatus;
use App\Models\Product;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProductForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public int $sort_order = 0;
    public ?int $category_id = null;
    public ?string $title = '';
    public ?string $slug = '';
    public ?string $description = null;
    public ?float $price = null;
    public ?float $sale_price = null;
    public ?array $product_types = null;
    public $image = null;
    public ?string $affiliate_link = null;
    public ?string $affiliate_source = null;
    public string $status = ProductStatus::ACTIVE->value;



    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'sometimes|required|string|max:255|unique:products,slug,' . $this->id
            : 'required|string|max:255|unique:products,slug';
        
        $imageRule = $this->isUpdating()
            ? 'nullable|image|max:2048'
            : 'nullable|image|max:2048';

        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/|lt:price',
            'product_types' => 'nullable|array',
            'image' => $imageRule,
            'affiliate_link' => 'required|url:http,https|max:255',
            'affiliate_source' => 'nullable|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(ProductStatus::cases(), 'value')),
        ];
    }


    /**
     * Fill the form fields from a Product model
     */
    public function setData(Product $data): void
    {
        $this->id = $data->id;
        $this->sort_order = $data->sort_order;
        $this->category_id = $data->category_id;
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->description = $data->description;
        $this->price = $data->price;
        $this->sale_price = $data->sale_price;
        $this->product_types = $data->product_types;
        $this->affiliate_link = $data->affiliate_link;
        $this->affiliate_source = $data->affiliate_source;
        $this->status = $data->status->value;
    }

    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->sort_order = 0;
        $this->category_id = null;
        $this->title = '';
        $this->slug = '';
        $this->description = null;
        $this->price = null;
        $this->sale_price = null;
        $this->product_types = null;
        $this->image = null;
        $this->affiliate_link = null;
        $this->affiliate_source = null;
        $this->status = ProductStatus::ACTIVE->value;

        $this->resetValidation();
    }



    /**
     * Determine if the form is updating an existing record
     */
    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}