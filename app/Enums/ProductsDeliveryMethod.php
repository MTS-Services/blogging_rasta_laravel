<?php
 
namespace App\Enums;
 
enum ProductsDeliveryMethod: string
{
    case AUTOMATIC = 'automatic';
    case MANUAL = 'manual';
    case FACE_TO_FACE = 'face_to_face';
 
    public function label(): string
    {
        return match($this) {
            self::AUTOMATIC => 'Automatic',
            self::MANUAL => 'Manual',
            self::FACE_TO_FACE => 'Face to Face',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::AUTOMATIC => 'badge-success',
            self::MANUAL => 'badge-info',
            self::FACE_TO_FACE => 'badge-primary',
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