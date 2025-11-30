<?php

namespace App\Livewire\Forms\Backend\Admin;

use Livewire\Form;
use App\Models\UserCategory;
use App\Enums\UserCategoryStatus;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;

class UserCategoryForm extends Form
{

    #[Locked]
    public ?int $id = null;

    public int $sort_order = 0;
    public ?string $title = '';
    public string $status = UserCategoryStatus::ACTIVE->value;



    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'status' => 'required|string|in:' . implode(',', array_column(UserCategoryStatus::cases(), 'value')),
        ];
    }


    /**
     * Fill the form fields from a Language model
     */
    public function setData(UserCategory $data): void
    {
        $this->id = $data->id;
        $this->title = $data->title;
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
        $this->status = UserCategoryStatus::ACTIVE->value;


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
