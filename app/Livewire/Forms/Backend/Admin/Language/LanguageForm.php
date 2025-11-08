<?php

namespace App\Livewire\Forms\Backend\Admin\Language;

use Livewire\Attributes\Validate;
use Livewire\Form;

class LanguageForm extends Form
{
    #[Validate('required|string|unique:languages,locale|max:255')]
    public string $locale = '';

    #[Validate('required|string|unique:languages,name|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public ?string $native_name = '';

    #[Validate('required|string')]
    public string $status = '';

    #[Validate('required|boolean')]
    public string $is_active = '';

    #[Validate('required|string')]
    public string $direction = '';


    public function rules(): array
    {
        return [
            'locale' => 'required|string|unique:languages,locale|max:255',
            'name' => 'required|string|unique:languages,name|max:255',
            'native_name' => 'nullable|string|max:255',
            'status' => 'required|string',
            'is_active' => 'required|boolean',
            'direction' => 'required|string',
        ];
    }
    public function setUser($user): void
    {
        $this->locale = $this->$user->locale;
        $this->name = $this->$user->name;
        $this->native_name = $this->$user->native_name;
        $this->status = $this->$user->status->value;
        $this->is_active = $this->$user->is_active;
        $this->direction = $this->$user->direction->value;
    }
    public function reset(...$properties)
    {
        $this->locale = '';
        $this->name = '';
        $this->native_name = '';
        $this->status = '';
        $this->is_active = '';
        $this->direction = '';

        $this->resetValidation();
    }
}
