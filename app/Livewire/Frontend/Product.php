<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;

class Product extends Component
{
    use WithPagination;

    public $perPage = 12; // Items per page
    public $products;

    public function mount()
    {
        $this->products = $this->getProductsProperty();
    }

    /**
     * Get paginated products data.
     */
    public function getProductsProperty()
    {
        // All products data
        $allProducts = $this->getAllProductsData();

        // Calculate pagination
        $currentPage = $this->getPage();
        $offset = ($currentPage - 1) * $this->perPage;

        return collect($allProducts)->slice($offset, $this->perPage)->values()->all();
    }

    /**
     * Get total number of pages
     */
    public function getTotalPagesProperty()
    {
        $allProducts = $this->getAllProductsData();
        return (int) ceil(count($allProducts) / $this->perPage);
    }

    /**
     * Get total number of products
     */
    public function getTotalProductsProperty()
    {
        return count($this->getAllProductsData());
    }

    /**
     * All products data - centralized method
     */
    public function getAllProductsData()
    {
        return [
            [
                'image' => 'assets/images/products/product1.png',
                'title' => 'Hydrating Face Essence',
                'price' => '$12',
                'type' => 'Dry',
                'rating' => 4.6,
            ],
            [
                'image' => 'assets/images/products/product2.png',
                'title' => 'Gentle Cleansing Oil',
                'price' => '$13',
                'type' => 'Normal',
                'rating' => 4.9,
            ],
            [
                'image' => 'assets/images/products/product3.png',
                'title' => 'Brightening Serum',
                'price' => '$10',
                'type' => 'All types',
                'rating' => 4.8,
            ],
            [
                'image' => 'assets/images/products/product4.png',
                'title' => 'Moisturizing Night Cream',
                'price' => '$15',
                'type' => 'Dry',
                'rating' => 4.5,
            ],
            [
                'image' => 'assets/images/products/product5.png',
                'title' => 'Acne Control Mask',
                'price' => '$9',
                'type' => 'Combination',
                'rating' => 4.7,
            ],
            [
                'image' => 'assets/images/products/product6.png',
                'title' => 'SPF 50 Sunscreen',
                'price' => '$16',
                'type' => 'All types',
                'rating' => 4.9,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.frontend.product');
    }
}
