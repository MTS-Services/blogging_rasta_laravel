<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Category;

use Livewire\Component;
use App\Models\Category;
use App\Enums\CategoryStatus;
use Livewire\Attributes\Locked;
use App\Services\CategoryService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Product\CategoryForm;

class Edit extends Component
{

    use WithNotification;

    public CategoryForm $form;

    #[Locked]
    public Category $data;
    protected CategoryService $service;

    /**
     * Inject the CategoryService via the boot method.
     */
    public function boot(CategoryService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Category $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.product-management.category.edit', [
            'statuses' => CategoryStatus::options(),
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
            return $this->redirect(route('admin.pm.category.index'), navigate: true);
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
