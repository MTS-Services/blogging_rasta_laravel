<?php

namespace App\Livewire\Backend\Admin\TikTokManagement\UserCategory;

use Livewire\Component;
use App\Models\UserCategory;
use App\Enums\UserCategoryStatus;
use Livewire\Attributes\Locked;
use App\Services\UserCategoryService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\UserCategoryForm;

class Edit extends Component
{

    use WithNotification;

    public UserCategoryForm $form;

    #[Locked]
    public UserCategory $data;
    protected UserCategoryService $service;

    /**
     * Inject the CategoryService via the boot method.
     */
    public function boot(UserCategoryService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(UserCategory $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.user-category.edit', [
            'statuses' => UserCategoryStatus::options(),
        ]);
    }


    /**
     * Handle form submission to update the language.
     */
    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);

            $this->success('Data updated successfully.');
            return $this->redirect(route('admin.tm.user-category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    /**
     * Cancel editing and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->setData($this->currency);
        $this->form->resetValidation();
    }
}
