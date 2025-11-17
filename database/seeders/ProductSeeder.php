<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Enums\ProductStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'sort_order'       => 1,
                'category_id'      => 1, // Cleansers
                'title'            => 'CeraVe Hydrating Facial Cleanser',
                'slug'             => 'cerave-hydrating-facial-cleanser',
                'description'      => 'A gentle hydrating cleanser with ceramides and hyaluronic acid.',
                'price'            => 15.50,
                'sale_price'       => 12.99,
                'product_types'    => json_encode(['Dry Skin', 'Normal Skin']),
                'image'            => 'products/cerave-cleanser.jpg',
                'affiliate_link'   => 'https://amazon.com/cerave-cleanser',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],

            [
                'sort_order'       => 2,
                'category_id'      => 4, // Serums
                'title'            => 'The Ordinary Niacinamide 10% + Zinc 1%',
                'slug'             => 'the-ordinary-niacinamide-serum',
                'description'      => 'Brightening serum for reducing blemishes and oiliness.',
                'price'            => 10.90,
                'sale_price'       => null,
                'product_types'    => json_encode(['Oily Skin', 'Acne-Prone Skin']),
                'image'            => 'products/ordinary-niacinamide.jpg',
                'affiliate_link'   => 'https://amazon.com/niacinamide-serum',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],

            [
                'sort_order'       => 3,
                'category_id'      => 7, // Sunscreen
                'title'            => 'La Roche-Posay Anthelios Melt-in Milk Sunscreen SPF 60',
                'slug'             => 'anthelios-spf-60-sunscreen',
                'description'      => 'Broad spectrum high protection sunscreen for face and body.',
                'price'            => 29.99,
                'sale_price'       => 24.99,
                'product_types'    => json_encode(['All Skin Types']),
                'image'            => 'products/anthelios-spf60.jpg',
                'affiliate_link'   => 'https://amazon.com/anthelios-sunscreen',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
