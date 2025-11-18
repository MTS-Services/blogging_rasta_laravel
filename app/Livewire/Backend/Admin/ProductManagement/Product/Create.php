<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use Livewire\Component;
use App\Enums\ProductStatus;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Product\ProductForm;
use App\Models\Category;
use App\Services\CategoryService;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithNotification, WithFileUploads;

    public ProductForm $form;
    public string $productTypeInput = '';

    protected ProductService $service;
    protected CategoryService $categoryService;

    /**
     * Inject the ProductService via the boot method.
     */
    public function boot(ProductService $service, CategoryService $categoryService): void
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = ProductStatus::ACTIVE->value;
         $this->form->product_types = [];
    }




     /**
     * Add a product type when Enter is pressed
     */
    public function addProductType(): void
    {
        $value = trim($this->productTypeInput);
        
        // Check if input is not empty
        if (empty($value)) {
            return;
        }

        // Initialize array if null
        if ($this->form->product_types === null) {
            $this->form->product_types = [];
        }

        // Check if already exists (case-insensitive)
        $exists = collect($this->form->product_types)
            ->map(fn($type) => strtolower($type))
            ->contains(strtolower($value));

        if ($exists) {
            $this->addError('productTypeInput', 'this product type already exists');
            return;
        }

        // Add to array
        $this->form->product_types[] = $value;
        
        // Clear input
        $this->productTypeInput = '';
        $this->resetErrorBag('productTypeInput');
    }

    /**
     * Remove a specific product type
     */
    public function removeProductType(int $index): void
    {
        if (isset($this->form->product_types[$index])) {
            unset($this->form->product_types[$index]);
            // Re-index array
            $this->form->product_types = array_values($this->form->product_types);
        }
    }


    /**
     * Render the component view.
     */
    public function render()
    {
         $category = $this->categoryService->getAllDatas();
        return view('livewire.backend.admin.product-management.product.create', [
            'categories' => $category,
            'statuses' => ProductStatus::options(),
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
            return $this->redirect(route('admin.pm.product.index'), navigate: true);
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
