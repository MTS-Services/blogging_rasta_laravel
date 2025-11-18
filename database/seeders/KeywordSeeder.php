<?php

namespace Database\Seeders;

use Firebase\JWT\Key;
use App\Models\Keyword;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keywords = [
            [
                'sort_order'       => 1,
             
                'name'            => 'SkincareTips',
                'created_by'       => 1,
                'updated_by'       => 1,
            ],

            [
                'sort_order'       => 2,
                
                'name'            => 'BeautyHaul',
               
                'created_by'       => 1,
                'updated_by'       => 1,
            ],

            [
                'sort_order'       => 3,
                
                'name'            => 'SkincareRoutine',
                
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
            [
                'sort_order'       => 3,
                
                'name'            => 'NaturalBeauty',
                
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
            [
                'sort_order'       => 6,
                
                'name'            => 'DiodioTips',
                
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
            [
                'sort_order'       => 10,
                
                'name'            => 'GlowSkin',
                
                'created_by'       => 1,
                'updated_by'       => 1,
            ],
        ];

        foreach ($keywords as $keyword) {
            Keyword::create($keyword);
        }
    }
}
