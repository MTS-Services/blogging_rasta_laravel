<?php

namespace App\Livewire\Forms\Auth\Otp;

use App\Enums\AdminStatus;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OtpForm extends Form
{
    #[Validate('required|string|size:6')]
    public string $code = '';

    public function rules(): array
    {
        return [
            'code' => 'required|string|size:6',
        ];
    }
}