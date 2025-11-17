<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;


use App\Enums\UserStatus;
use App\Livewire\Forms\UserForm;
use App\Models\Admin;
use App\Services\UserService;
use App\Services\User\service;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public UserForm $form;

    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.user.create', [
            'statuses' => UserStatus::options(),
        ]);
    }
    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['creater_id'] = admin()->id;
            $validated['creater_type'] = Admin::class;
            $this->service->createData($validated, admin()->id);

            $this->dispatch('UserCreated');
            $this->success('Data created successfully');
            return $this->redirect(route('admin.um.user.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            $this->error('Failed to create user.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
}
