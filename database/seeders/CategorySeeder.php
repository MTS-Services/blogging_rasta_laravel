<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Enums\CategoryStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'sort_order' => 1,
                'title'      => 'Cleansers',
                'slug'       => 'cleansers',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 2,
                'title'      => 'Toners',
                'slug'       => 'toners',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 3,
                'title'      => 'Moisturizers',
                'slug'       => 'moisturizers',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 4,
                'title'      => 'Serums',
                'slug'       => 'serums',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 5,
                'title'      => 'Face Masks',
                'slug'       => 'face-masks',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 6,
                'title'      => 'Exfoliators',
                'slug'       => 'exfoliators',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 7,
                'title'      => 'Sunscreen',
                'slug'       => 'sunscreen',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 8,
                'title'      => 'Eye Care',
                'slug'       => 'eye-care',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 9,
                'title'      => 'Lip Care',
                'slug'       => 'lip-care',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
            [
                'sort_order' => 10,
                'title'      => 'Acne Treatment',
                'slug'       => 'acne-treatment',
                'status'     => CategoryStatus::ACTIVE->value,
            ],
        ];


        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
