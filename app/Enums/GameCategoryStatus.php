<?php

namespace App\Enums;

enum GameCategoryStatus: string
{
    //
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

   public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'badge-success',
            self::INACTIVE => 'badge-danger',
        };
    }

    public static function options(): array 
    {
        return array_map(fn($case) => ['value' => $case->value, 'label' => $case->label()], self::cases());
    }
}
