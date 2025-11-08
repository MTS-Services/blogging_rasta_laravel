<?php

namespace App\Livewire\Forms\Backend\Admin\AdminManagement;

use App\Enums\AdminStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;

class AdminForm extends Form
{


    #[Locked]
    public ?int $id = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?string $password_confirmation = '';
    public ?string $phone = '';
    public ?string $address = '';
    public string $status = '';
    public ?UploadedFile $avatar = null;
    public bool $remove_avatar = false;


    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => $this->isUpdating() ? 'nullable|string|min:8' : 'required|string|min:8',
            'password_confirmation' => 'nullable|string|min:8|same:password',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(AdminStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048',
        ];

        return $rules;
    }

    public function setData($admin): void
    {
        $this->id = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->phone = $admin->phone;
        $this->address = $admin->address;
        $this->status = $admin->status->value;
        $this->avatar = null;
        
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->phone = '';
        $this->address = '';
        $this->status = AdminStatus::ACTIVE->value;
        $this->avatar = null;
        $this->remove_avatar = false;

        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }

    public function fillables(){
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'avatar' => $this->avatar
        ];
    }
}
