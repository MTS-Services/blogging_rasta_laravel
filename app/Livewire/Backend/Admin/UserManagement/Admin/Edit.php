<?php

namespace App\Livewire\Backend\Admin\UserManagement\Admin;

use App\Enums\AdminStatus;
use App\Livewire\Forms\AdminForm;
use App\Models\Admin;
use App\Services\AdminService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;
    public Admin $model;
    public $existingFile;

    protected AdminService $service;

    public function boot(AdminService $service)
    {
        $this->service = $service;
    }

    public function mount(Admin $model): void
    {
        $this->model = $model;
        $this->form->setData($model);
        $this->existingFile = $model->avatar;
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.admin.edit', [
            'statuses' => AdminStatus::options(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['updated_by'] = admin()->id;
            $this->model = $this->service->updateData($this->model->id, $validated);

            $this->dispatch('AdminUpdated');
            $this->success('Data updated successfully');
            return $this->redirect(route('admin.um.admin.index'), navigate: true);
        } catch (\Throwable $e) {
            Log::error('Failed to update Admin', [
                'admin_id' => $this->model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update Admin.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->model);
    }
}
