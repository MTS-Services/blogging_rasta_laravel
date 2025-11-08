<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;


use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
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

    public function mount(): void
    {
        $this->form->status = AdminStatus::ACTIVE->value;
    }

    public function render()
    {
        return view('livewire.backend.admin.admin-management.admin.create', [
            'statuses' => AdminStatus::options(),
        ]);
    }
    public function save()
    {


        try {
            $data =  $this->form->fillables();

            $data['created_by'] = admin()->id;
            $this->service->createData($data);

            $this->dispatch('Admin is created');

            $this->success('Admin created successfully');

            return $this->redirect(route('admin.am.admin.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error('Failed to create user: ' . $e->getMessage());

            $this->error('Failed to create user: ');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
    public function cancel(): void
    {
        $this->redirect(route('admin.am.admin.index'), navigate: true);
    }
}
