<?php
 
namespace App\Enums;
 
enum CountryKycSettingType: string
{
    case SELLER = 'seller';
    case BUYER = 'buyer';
 
    public function label(): string
    {
        return match($this) {
            self::SELLER => 'Seller',
            self::BUYER => 'Buyer',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::SELLER => 'badge-success',
            self::BUYER => 'badge-primary',
        };
    }
 
    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}