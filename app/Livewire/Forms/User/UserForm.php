<?php

namespace App\Livewire\Forms\User;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $phone;
    public $status;


    public function mount(User $user)
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->status = $user->status->value;
        $this->password = '';
    }


    public function rules(): array
    {
        $emailRule = $this->userId
            ? "required|email|max:255|unique:users,email,{$this->userId}"
            : 'required|email|max:255|unique:users,email';

        $passwordRule = $this->userId
            ? 'nullable|string|min:8'
            : 'required|string|min:8';

        return [
            'name' => 'required|string|min:3|max:255',
            'email' => $emailRule,
            'password' => $passwordRule,
            'phone' => 'nullable|string|max:20',
            'status' => 'required|string|in:active,inactive,suspended',
        ];
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
        ];

        if ($this->password) {
            $data['password'] = $this->password;
        }

        return $data;
    }
}
