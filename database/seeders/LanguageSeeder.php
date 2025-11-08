<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Enums\LanguageStatus;
use Illuminate\Database\Seeder;
use App\Enums\LanguageDirection;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'sort_order'   => 1,
                'locale'       => 'en',
                'name'         => 'English',
                'native_name'  => 'English',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_active'    => true,
                'direction'    => LanguageDirection::LTR->value,
                'flag_icon'    => 'us.svg',
            ],
            [
                'sort_order'   => 2,
                'locale'       => 'es',
                'name'         => 'Spanish',
                'native_name'  => 'Español',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_active'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'flag_icon'    => 'us.svg',
            ],
            [
                'sort_order'   => 3,
                'locale'       => 'bn',
                'name'         => 'Bangla',
                'native_name'  => 'বাংলা',
                'status'       => LanguageStatus::ACTIVE->value,
                'is_active'    => false,
                'direction'    => LanguageDirection::LTR->value,
                'flag_icon'    => 'us.svg',
            ],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(
                ['locale' => $lang['locale']],
                $lang
            );
        }
    }
}
