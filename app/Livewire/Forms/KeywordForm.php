<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class KeywordForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;
    public int $sort_order = 0;
    public string $name = '';




    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        $nameRule = $this->isUpdating()
            ? 'sometimes|required|string|max:255|unique:keywords,name,' . $this->id
            : 'required|string|max:255|unique:keywords,name';

        return [
            'name' => $nameRule,
        ];
    }

    // ---------------------------
    // Fill Form with Existing Data
    // ---------------------------
    public function setData($data): void
    {
        $this->id                = $data->id;
        $this->name             = $data->name;
    }

    // ---------------------------
    // Reset Form
    // ---------------------------
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->sort_order = 0;

        $this->resetValidation();
    }



    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
