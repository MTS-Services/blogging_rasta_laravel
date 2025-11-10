<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Enums\AdminStatus;
use App\Livewire\Forms\UserForm;
use App\Models\Admin;
use App\Models\User;
use App\Services\UserService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public UserForm $form;
    public User $model;

    protected UserService $service;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }

    public function mount(User $model): void
    {
        $this->model = $model;
        $this->form->setData($model);
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.user.edit', [
            'statuses' => AdminStatus::options(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['updater_id'] = admin()->id;
            $validated['updater_type'] = Admin::class;
            $this->service->updateData($this->model->id, $validated);

            $this->dispatch('UserUpdated');
            $this->success('User updated successfully');
            return $this->redirect(route('admin.um.user.index'), navigate: true);
        } catch (\Throwable $e) {
            Log::error('Failed to update user', [
                'user_id' => $this->model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update user.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->model);
    }
}
