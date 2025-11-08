<?php

namespace App\Livewire\Forms\Backend\Admin\ProductManagement;

use Livewire\Form;
use App\Models\ProductType;
use Livewire\Attributes\Locked;
use App\Enums\ProductTypeStatus;
use Livewire\Attributes\Validate;

class ProductTypeForm extends Form
{
    #[Locked]
    public ?int $id = null;


    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public ?string $icon = null;

    public bool $requires_delivery_time = true;
    public bool $requires_server_info = false;
    public bool $requires_character_info = false;
    public int $max_delivery_time_hours = 24;
    public ?float $commission_rate = null;
    public ?string $status = ProductTypeStatus::ACTIVE->value;

    /**
     * Validation rules (handles create/update logic)
     */

    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'required|string|max:255|unique:product_types,slug,' . $this->id
            : 'required|string|max:255|unique:product_types,slug';

        return [
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'requires_delivery_time' => 'required|boolean',
            'requires_server_info' => 'required|boolean',
            'requires_character_info' => 'required|boolean',
            'max_delivery_time_hours' => 'required|integer',
            'commission_rate' => 'nullable|numeric',
            'status' => 'required|string|in:' . implode(',', array_column(ProductTypeStatus::cases(), 'value')),

        ];
    }

    /**
     * Fill the form fields from a ProductType model
     */
    public function setData(ProductType $productType): void
    {
        $this->id = $productType->id;
        $this->name = $productType->name;
        $this->slug = $productType->slug;
        $this->description = $productType->description;
        $this->icon = $productType->icon;
        $this->requires_delivery_time = $productType->requires_delivery_time;
        $this->requires_server_info = $productType->requires_server_info;
        $this->requires_character_info = $productType->requires_character_info;
        $this->max_delivery_time_hours = $productType->max_delivery_time_hours;
        $this->commission_rate = $productType->commission_rate;
        $this->status = $productType->status->value;
    }

    /**
     * Reset form fields
     */

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->slug = '';
        $this->description = null;
        $this->icon = null;
        $this->requires_delivery_time = true;
        $this->requires_server_info = false;
        $this->requires_character_info = false;
        $this->max_delivery_time_hours = 24;
        $this->commission_rate = null;
        $this->status = ProductTypeStatus::ACTIVE->value;

        $this->resetValidation();
    }


    /**
     * Determine if the form is updating an existing record
     */
    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }

    public function fillables(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'requires_delivery_time' => $this->requires_delivery_time,
            'requires_server_info' => $this->requires_server_info,
            'requires_character_info' => $this->requires_character_info,
            'max_delivery_time_hours' => $this->max_delivery_time_hours,
            'commission_rate' => $this->commission_rate,
            'status' => $this->status,
        ];
    }
}
