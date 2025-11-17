<?php

namespace App\Livewire\Forms\Product;

use Livewire\Form;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CategoryForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public int $sort_order = 0;
    public ?string $title = '';
    public ?string $slug = '';
    public string $status = CategoryStatus::ACTIVE->value;



    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'sometimes|required|string|max:255|unique:categories,slug,' . $this->id
            : 'required|string|max:255|unique:categories,slug';
        return [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'status' => 'required|string|in:' . implode(',', array_column(CategoryStatus::cases(), 'value')),
        ];
    }


    /**
     * Fill the form fields from a Language model
     */
    public function setData(Category $data): void
    {
        $this->id = $data->id;
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->status = $data->status->value;
        
    }

    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->sort_order = 0;
        $this->title = '';
        $this->slug = '';
        $this->status = CategoryStatus::ACTIVE->value;


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
