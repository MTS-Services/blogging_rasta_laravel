<?php

namespace App\Livewire\Forms;

use App\Enums\AdminStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Form;

class AdminForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public ?string $password_confirmation = '';
    public string $status = AdminStatus::ACTIVE->value;
    public ?UploadedFile $avatar = null;
    public bool $remove_file = false;

    public function rules(): array
    {

        $email = $this->isUpdating() ? 'sometimes|required|email|max:255|unique:admins,email,' . $this->id : 'sometimes|required|email|max:255|unique:admins,email';
        $password = $this->isUpdating() ? 'nullable|string|min:8' : 'sometimes|required|string|min:8|confirmed';
        return [
            'name' => 'sometimes|required|string|max:50',
            'email' => $email,
            'password' => $password,
            'remove_file'      => 'boolean',
            'password_confirmation' => 'sometimes|nullable|string|min:8|same:password',
            'status' => 'required|string|in:' . implode(',', array_column(AdminStatus::cases(), 'value')),
            'avatar' => 'nullable|image',
        ];
    }

    public function setData($admin): void
    {
        $this->id = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->status = $admin->status->value;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = AdminStatus::ACTIVE->value;
        $this->avatar = null;
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
