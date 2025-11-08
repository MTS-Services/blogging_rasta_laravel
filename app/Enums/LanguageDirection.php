<?php

namespace App\Enums;

enum LanguageDirection: string
{
    case LTR = 'ltr';
    case RTL = 'rtl';

    public function label(): string
    {
        return match($this){
            self::LTR => 'Left to Right',
            self::RTL => 'Right to Left',
        };
    }
    public function color(): string
    {
        return match($this){
            self::LTR => 'badge-success',
            self::RTL => 'badge-secondary',
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
