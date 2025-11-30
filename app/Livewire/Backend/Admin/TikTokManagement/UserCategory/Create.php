<?php

namespace App\Livewire\Backend\Admin\TikTokManagement\UserCategory;

use Livewire\Component;
use App\Enums\UserCategoryStatus;
use App\Services\UserCategoryService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\UserCategoryForm;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public UserCategoryForm $form;

    protected UserCategoryService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(UserCategoryService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = UserCategoryStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.user-category.create', [
            'statuses' => UserCategoryStatus::options(),
        ]);
    }

    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();

        try {
            $data['created_by'] = admin()->id;
            $this->service->createData($data);
            $this->success('Data created successfully.');
            return $this->redirect(route('admin.tm.user-category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }
}
