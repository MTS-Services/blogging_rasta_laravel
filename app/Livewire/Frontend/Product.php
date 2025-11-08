<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;

class Product extends Component
{
    use WithPagination;

    public $perPage = 12; // Items per page

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
                'id' => 1,
                'name' => '2025 Nissan Kicks S',
                'price_per_day' => 99,
                'location' => 'Dallas, Texas',
                'persons' => 5,
                'tags' => 'Courier, Share, UberX',
                'features' => ['CarPlay'],
                'trips' => 4,
                'image_name' => 'car (1).avif',
            ],
            [
                'id' => 2,
                'name' => '2023 Honda Civic LX',
                'price_per_day' => 85,
                'location' => 'Austin, Texas',
                'persons' => 4,
                'tags' => 'Economy, Commuter',
                'features' => ['Bluetooth'],
                'trips' => 12,
                'image_name' => 'car (2).avif',
            ],
            [
                'id' => 3,
                'name' => '2024 Toyota Camry SE',
                'price_per_day' => 110,
                'location' => 'Houston, Texas',
                'persons' => 5,
                'tags' => 'Sedan, Comfort',
                'features' => ['Sunroof'],
                'trips' => 7,
                'image_name' => 'car (3).avif',
            ],
            [
                'id' => 4,
                'name' => '2022 Ford Mustang GT',
                'price_per_day' => 180,
                'location' => 'San Antonio, Texas',
                'persons' => 4,
                'tags' => 'Sports Car, Weekend',
                'features' => ['V8 Engine'],
                'trips' => 2,
                'image_name' => 'car (4).avif',
            ],
            [
                'id' => 5,
                'name' => '2025 Tesla Model 3',
                'price_per_day' => 150,
                'location' => 'El Paso, Texas',
                'persons' => 5,
                'tags' => 'Electric, Luxury',
                'features' => ['Autopilot'],
                'trips' => 9,
                'image_name' => 'car (5).avif',
            ],
            [
                'id' => 6,
                'name' => '2023 Chevrolet Tahoe',
                'price_per_day' => 135,
                'location' => 'Lubbock, Texas',
                'persons' => 7,
                'tags' => 'SUV, Family',
                'features' => ['3rd Row'],
                'trips' => 6,
                'image_name' => 'car (6).avif',
            ],
            [
                'id' => 7,
                'name' => '2024 Subaru Outback',
                'price_per_day' => 105,
                'location' => 'Denver, Colorado',
                'persons' => 5,
                'tags' => 'AWD, Adventure',
                'features' => ['Eyesight Safety'],
                'trips' => 15,
                'image_name' => 'car (7).avif',
            ],
            [
                'id' => 8,
                'name' => '2021 BMW 3 Series',
                'price_per_day' => 160,
                'location' => 'Miami, Florida',
                'persons' => 4,
                'tags' => 'Luxury, Executive',
                'features' => ['Leather Seats'],
                'trips' => 3,
                'image_name' => 'car (8).avif',
            ],
            [
                'id' => 9,
                'name' => '2023 Kia Telluride',
                'price_per_day' => 120,
                'location' => 'Atlanta, Georgia',
                'persons' => 7,
                'tags' => 'SUV, Premium',
                'features' => ['Navigation'],
                'trips' => 10,
                'image_name' => 'car (9).avif',
            ],
            [
                'id' => 10,
                'name' => '2022 Jeep Wrangler',
                'price_per_day' => 145,
                'location' => 'Phoenix, Arizona',
                'persons' => 4,
                'tags' => 'Off-Road, Fun',
                'features' => ['Convertible Top'],
                'trips' => 8,
                'image_name' => 'car (10).avif',
            ],
            [
                'id' => 11,
                'name' => '2024 Mazda CX-5',
                'price_per_day' => 95,
                'location' => 'Seattle, Washington',
                'persons' => 5,
                'tags' => 'Crossover, Stylish',
                'features' => ['Backup Camera'],
                'trips' => 14,
                'image_name' => 'car (11).avif',
            ],
            [
                'id' => 12,
                'name' => '2023 Ram 1500',
                'price_per_day' => 175,
                'location' => 'Chicago, Illinois',
                'persons' => 5,
                'tags' => 'Truck, Towing',
                'features' => ['Hemi V8'],
                'trips' => 5,
                'image_name' => 'car (12).avif',
            ],
            [
                'id' => 13,
                'name' => '2024 Hyundai Tucson',
                'price_per_day' => 92,
                'location' => 'Boston, Massachusetts',
                'persons' => 5,
                'tags' => 'SUV, Efficient',
                'features' => ['Lane Assist'],
                'trips' => 11,
                'image_name' => 'car (13).avif',
            ],
            // Add more products here as needed
            // The pagination will automatically handle any amount of data
        ];
    }

    public function render()
    {
        return view('livewire.frontend.product');
    }
}