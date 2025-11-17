<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Category;

use Livewire\Component;
use App\Enums\CategoryStatus;
use App\Services\CategoryService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Product\CategoryForm;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public CategoryForm $form;

    protected CategoryService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */
    public function boot(CategoryService $service): void
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = CategoryStatus::ACTIVE->value;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.backend.admin.product-management.category.create', [
            'statuses' => CategoryStatus::options(),
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
            return $this->redirect(route('admin.pm.category.index'), navigate: true);
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
