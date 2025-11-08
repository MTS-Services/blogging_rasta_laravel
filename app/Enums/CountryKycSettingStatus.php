<?php
 
namespace App\Enums;
 
enum CountryKycSettingStatus: string
{
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
        return match($this) {
            self::ACTIVE => 'badge-success',
            self::INACTIVE => 'badge-secondary',
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