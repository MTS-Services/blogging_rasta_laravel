<?php

namespace App\Enums;

enum SellerLevel: string
{
    case BRONZE = 'bronze';
    case SILVER = 'silver';
    case GOLD = 'gold';
    case PLATINUM = 'platinum';
    case DIAMOND = 'diamond';


    public function label(): string
    {
        return match ($this) {
            self::BRONZE => 'Bronze',
            self::SILVER => 'Silver',
            self::GOLD => 'Gold',
            self::PLATINUM => 'Platinum',
            self::DIAMOND => 'Diamond',
        };
    }


    public function color(): string
    {
        return match ($this) {
            self::BRONZE => 'badge badge-warning',
            self::SILVER => 'badge badge-secondary',
            self::GOLD => 'badge badge-primary', 
            self::PLATINUM => 'badge badge-info',
            self::DIAMOND => 'badge badge-success',
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
