<?php

namespace App\Enums;

enum BlogStatus: string
{
     case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';

    public function label(): string
    {
        return match ($this) {
            self::PUBLISHED => 'Published',
            self::UNPUBLISHED => 'Unpublished',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PUBLISHED => 'badge badge-success',
            self::UNPUBLISHED => 'badge badge-warning',
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
