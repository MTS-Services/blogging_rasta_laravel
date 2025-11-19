<?php

namespace App\Livewire\Frontend;

use App\Enums\ProductStatus;
use App\Services\CategoryService;
use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithPagination;

class Product extends Component
{
    use WithPagination;

    protected ProductService $productservice;
    protected CategoryService $categoryService;

    public $selectedCategory = 'All';
    public $perPage = 6;

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function boot(ProductService $productservice, CategoryService $categoryService)
    {
        $this->productservice = $productservice;
        $this->categoryService = $categoryService;
    }

    /**
     * Select category filter
     */
    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    /**
     * Get filtered products based on selected category
     */
   public function getFilteredProducts()
    {
        $filters = [
            'status' => ProductStatus::ACTIVE->value, // Always only active
        ];

        if ($this->selectedCategory !== 'All') {
            $filters['category_id'] = $this->selectedCategory;
        }

        return $this->productservice->getPaginatedData(
            perPage: $this->perPage,
            filters: $filters
        );
    }

    /**
     * Custom pagination methods
     */
    public function goToPage($page)
    {
        $this->setPage($page);
    }

    public function hasPreviousPage()
    {
        return $this->getPage() > 1;
    }

    public function hasNextPage()
    {
        $products = $this->getFilteredProducts();
        return $products->hasMorePages();
    }

    public function getTotalPages()
    {
        $products = $this->getFilteredProducts();
        return $products->lastPage();
    }

    public function shouldShowPagination()
    {
        $products = $this->getFilteredProducts();
        return $products->hasPages();
    }

    public function getCurrentPage()
    {
        return $this->getPage();
    }

    public function render()
    {
        $products = $this->getFilteredProducts();
        $categories = $this->categoryService->getAllDatas();
        
        return view('livewire.frontend.product', [
            'products' => $products,
            'categories' => $categories,
            'currentPage' => $this->getCurrentPage(),
        ]);
    }

   
}