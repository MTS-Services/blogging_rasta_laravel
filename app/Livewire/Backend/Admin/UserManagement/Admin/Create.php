<?php

namespace App\Livewire\Backend\Admin\UserManagement\Admin;


use App\Enums\AdminStatus;
use App\Livewire\Forms\AdminForm;
use App\Services\AdminService;
use App\Services\Admin\service;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;

    protected AdminService $service;

    public function boot(AdminService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.admin.create', [
            'statuses' => AdminStatus::options(),
        ]);
    }
    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['created_by'] = admin()->id;
            $this->service->createData($validated);

            $this->dispatch('AdminCreated');
            $this->success('Data created successfully');
            return $this->redirect(route('admin.um.admin.index'), navigate: true);
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
