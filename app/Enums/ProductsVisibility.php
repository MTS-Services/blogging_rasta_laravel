<?php
 
namespace App\Enums;
 
enum ProductsVisibility: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';
    case UNLISTED = 'unlisted';
 
    public function label(): string
    {
        return match($this) {
            self::PUBLIC => 'Public',
            self::PRIVATE => 'Private',
            self::UNLISTED => 'Unlisted',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::PUBLIC => 'badge-success',
            self::PRIVATE => 'badge-warning',
            self::UNLISTED => 'badge-danger',
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