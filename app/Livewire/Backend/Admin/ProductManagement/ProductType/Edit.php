<?php

namespace App\Livewire\Backend\Admin\ProductManagement\ProductType;

use Livewire\Component;
use App\Models\ProductType;
use Livewire\Attributes\Locked;
use App\Enums\ProductTypeStatus;
use App\Traits\Livewire\WithNotification;
use App\Services\ProductTypeService;
use App\Livewire\Forms\Backend\Admin\ProductManagement\ProductTypeForm;

class Edit extends Component
{
    use WithNotification;

    public ProductTypeForm $form;

    #[Locked]
    public ProductType $productType;
    protected ProductTypeService $service;
    

    public function boot(ProductTypeService $service)
    {
        $this->service = $service;
    }


    public function mount(ProductType $data): void
    {
        $this->productType = $data;
        $this->form->setData($this->productType);

    }

    public function render()
    {
        return view('livewire.backend.admin.product-management.product-type.edit', [
            'statuses' => ProductTypeStatus::options(),
        ]);
    }


    public function save()
    {
        $this->form->validate();
        try {
            $data = $this->form->fillables();
            $data['updater_id'] = admin()->id;
            $data['updater_by'] = admin()->id;
            $updated = $this->service->updateData($this->productType->id, $data);            

            $this->dispatch('ProductTypeUpdated');
            $this->success('Data updated successfully.');

            return $this->redirect(route('admin.pm.productType.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->setData($this->productType);
        $this->form->resetValidation();
    }
}
