<?php

namespace App\Livewire\Backend\Admin\ProductManagement\ProductType;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\ProductTypeStatus;
use App\Livewire\Forms\Backend\Admin\ProductManagement\ProductTypeForm;
use App\Services\ProductTypeService;
use App\Traits\Livewire\WithNotification;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public ProductTypeForm $form;

    protected ProductTypeService $service;
    public function boot(ProductTypeService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        // $this->status = ProductTypeStatus::ACTIVE->value;
    }
    public function render()
    {
        return view('livewire.backend.admin.product-management.product-type.create', [
            'statuses' => ProductTypeStatus::options(),
        ]);
    }


    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $this->form->validate();
        try {
            $data = $this->form->fillables();
            $data['creater_id'] = admin()->id;
            $data['creater_type'] = admin()->id;
            $this->service->createData($data);

            $this->success('Data created successfully.');

            return $this->redirect(route('admin.pm.productType.index'), navigate: true);
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
