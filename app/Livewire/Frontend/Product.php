<?php

namespace App\Livewire\Frontend;

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


    public function boot(ProductService $productservice, CategoryService $categoryService)
    {
       $this->productservice = $productservice;
        $this->categoryService = $categoryService;
    }

    /**
     * Get paginated products data.
     */
    

    /**
     * All products data - centralized method
     */

    // public function loadData()
    // {
    //     $this->products = [
    //         ['thumb' => 'product (1).png', 'name' => 'Hydrating Face Essence'],
    //         ['thumb' => 'product (3).png', 'name' => 'Gentle Cleansing Oil'],
    //         ['thumb' => 'product (4).png', 'name' => 'Brightening Serum'],
    //         ['thumb' => 'product (5).png', 'name' => 'Moisturizing Night Cream'],
    //         ['thumb' => 'product (6).png', 'name' => 'Acne Control Mask'],
    //         ['thumb' => 'product (7).png', 'name' => 'SPF 50 Sunscreen'],

    //     ];
    //     $this->products_names = [
    //         [],
    //         [],
    //         [],
    //         [],
    //         [],
    //         [],

    //     ];
    // }

    public function render()
    {
        $products = $this->productservice->getAllDatas();
        $categories = $this->categoryService->getAllDatas();
        return view('livewire.frontend.product', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
