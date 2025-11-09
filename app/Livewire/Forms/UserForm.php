<?php

namespace App\Livewire\Forms;

use App\Enums\UserStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Form;

class UserForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?string $password_confirmation = '';
    public string $status = UserStatus::ACTIVE->value;
    public ?UploadedFile $avatar = null;

    public function rules(): array
    {

        $email = $this->isUpdating() ? 'sometimes|required|email|max:255|unique:users,email,' . $this->id : 'sometimes|required|email|max:255|unique:users,email';
        $password = $this->isUpdating() ? 'nullable|string|min:8' : 'sometimes|required|string|min:8|confirmed';
        return [
            'name' => 'sometimes|required|string|max:50',
            'email' => $email,
            'password' => $password,
            'password_confirmation' => 'sometimes|nullable|string|min:8|same:password',
            'status' => 'required|string|in:' . implode(',', array_column(UserStatus::cases(), 'value')),
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    public function setData($admin): void
    {
        $this->id = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
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
        $this->status = UserStatus::ACTIVE->value;
        $this->avatar = null;
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
