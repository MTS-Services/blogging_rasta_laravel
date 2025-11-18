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
                'title'            => 'Hydrating Face Essence',
                'slug'             => 'hydrating-face-essence',
                'description'      => 'A gentle hydrating cleanser with ceramides and hyaluronic acid.',
                'price'            => 12,
                'sale_price'       => null,
                'product_types'    => json_encode(['Dry', 'Sensetive']),
                'image'            => 'assets/images/product/product (1).png',
                'affiliate_link'   => 'https://amazon.com/cerave-cleanser',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],

            [
                'sort_order'       => 2,
                'category_id'      => 4, // Serums
                'title'            => 'Gentle Cleansing Oil',
                'slug'             => 'gentle-cleansing-oil',
                'description'      => 'Brightening serum for reducing blemishes and oiliness.',
                'price'            => 13,
                'sale_price'       => null,
                'product_types'    => json_encode(['Oily', 'Normal']),
                'image'            => 'assets/images/product/product (3).png',
                'affiliate_link'   => 'https://amazon.com/niacinamide-serum',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],

            [
                'sort_order'       => 3,
                'category_id'      => 7, // Sunscreen
                'title'            => 'Brightening Serum',
                'slug'             => 'brightening-serum',
                'description'      => 'Broad spectrum high protection sunscreen for face and body.',
                'price'            => 10,
                'sale_price'       => 8,
                'product_types'    => json_encode(['All Skin Types']),
                'image'            => 'assets/images/product/product (4).png',
                'affiliate_link'   => 'https://amazon.com/anthelios-sunscreen',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
            [
                'sort_order'       => 3,
                'category_id'      => 2, // Sunscreen
                'title'            => 'Moisturizing Night Cream',
                'slug'             => 'moisturizing-night-cream',
                'description'      => 'Broad spectrum high protection sunscreen for face and body.',
                'price'            => 10,
                'sale_price'       => 8,
                'product_types'    => json_encode(['Dry', 'Sensetive']),
                'image'            => 'assets/images/product/product (5).png',
                'affiliate_link'   => 'https://amazon.com/anthelios-sunscreen',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
            [
                'sort_order'       => 6,
                'category_id'      => 3, // Sunscreen
                'title'            => 'Acne Control Mask',
                'slug'             => 'acne-control-mask',
                'description'      => 'Broad spectrum high protection sunscreen for face and body.',
                'price'            => 10,
                'sale_price'       => 8,
                'product_types'    => json_encode(['Oily', 'Combination']),
                'image'            => 'assets/images/product/product (6).png',
                'affiliate_link'   => 'https://amazon.com/anthelios-sunscreen',
                'affiliate_source' => 'Amazon',
                'status'           => ProductStatus::ACTIVE->value,
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
            [
                'sort_order'       => 10,
                'category_id'      => 7, // Sunscreen
                'title'            => 'SPF 50 Sunscreen',
                'slug'             => 'spf-50-sunscreen',
                'description'      => 'Broad spectrum high protection sunscreen for face and body.',
                'price'            => 10,
                'sale_price'       => 8,
                'product_types'    => json_encode(['Oily', 'Combination']),
                'image'            => 'assets/images/product/product (7).png',
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
