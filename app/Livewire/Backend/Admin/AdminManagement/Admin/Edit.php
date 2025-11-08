<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Enums\AdminStatus;
use App\Livewire\Forms\Backend\Admin\AdminManagement\AdminForm;
use App\Models\Admin;
use App\Services\AdminService;
use App\Services\Admin\service;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public AdminForm $form;
    public Admin $admin;
    public $existingAvatar;
    public $adminId;

    protected AdminService $service;


    public function boot(AdminService $service)
    {
        $this->service = $service;
    }

    public function mount(Admin $data): void
    {

        $this->admin = $data;
        $this->adminId = $data->id;
        $this->form->setData($data);
        $this->existingAvatar = $data->avatar_url;

        Log::info('AdminEdit mounted', [
            'admin_id' => $data->id,
            'form_data' => [
                'name' => $this->form->name,
                'email' => $this->form->email,
                'status' => $this->form->status,
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.backend.admin.admin-management.admin.edit', [
            'statuses' => AdminStatus::options(),
        ]);
    }

    public function save()
    {
        Log::info('Save method called', [
            'admin_id' => $this->adminId,
            'form_data' => [
                'name' => $this->form->name,
                'email' => $this->form->email,
                'password' => $this->form->password ? 'SET' : 'NOT SET',
                'phone' => $this->form->phone,
                'address' => $this->form->address,
                'status' => $this->form->status,


            ]
        ]);

        $this->form->validate();

        try {

            $data = $this->form->fillables();

            $data['updater_id'] = admin()->id;

            $this->admin = $this->service->updateData($this->adminId, $data);

            Log::info('Admin updated successfully', ['admin_id' => $this->admin->id]);


            $this->dispatch('AdminUpdated');
            $this->success('Admin updated successfully');

            // Redirect to Admin list
            return $this->redirect(route('admin.am.admin.index'), navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors()
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Failed to update Admin', [
                'admin_id' => $this->adminId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update Admin: ' . $e->getMessage());
        }
    }

    public function removeAvatar(): void
    {
        Log::info('removeAvatar called', ['admin_id' => $this->adminId]);
        $this->form->remove_avatar = true;
        $this->existingAvatar = null;
        $this->form->avatar = null;
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
