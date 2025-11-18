<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use App\Models\Product;
use Livewire\Component;
use App\Enums\ProductStatus;
use Livewire\Attributes\Locked;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Product\ProductForm;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads, WithNotification;

    public ProductForm $form;

    #[Locked]
    public Product $data;
    protected ProductService $service;
    protected CategoryService $categoryService;

    public $existingFile;
    public $existingFiles;

    /**
     * Inject the ProductService via the boot method.
     */
    public function boot(ProductService $service, CategoryService $categoryService): void
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    /**
     * Initialize form with existing language data.
     */
    public function mount(Product $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->image;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $category = $this->categoryService->getAllDatas();
        return view('livewire.backend.admin.product-management.product.edit', [
            'statuses' => ProductStatus::options(),
            'categories' => $category
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
            return $this->redirect(route('admin.pm.product.index'), navigate: true);
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
