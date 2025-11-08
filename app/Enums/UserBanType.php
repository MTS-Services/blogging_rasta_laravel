<?php
 
namespace App\Enums;
 
enum UserBanType: string
{
    case TEMPORARY = 'temporary';
    case PERMANENT = 'permanent';
 
    public function label(): string
    {
        return match($this) {
            self::TEMPORARY => 'Temporary',
            self::PERMANENT => 'Permanent',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::TEMPORARY => 'badge-warning',
            self::PERMANENT => 'badge-danger',
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