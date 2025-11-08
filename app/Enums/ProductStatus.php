<?php

namespace App\Enums;

enum ProductStatus: string
{
    case DRAFT = 'draft';
    case PENDING_REVIEW = 'pending_review';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REJECTED = 'rejected';
    case SOLD_OUT = 'sold_out';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING_REVIEW => 'Pending Review',
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::REJECTED => 'Rejected',
            self::SOLD_OUT => 'Sold Out',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'badge-secondary',
            self::PENDING_REVIEW => 'badge-warning',
            self::ACTIVE => 'badge-success',
            self::INACTIVE => 'badge-dark',
            self::REJECTED => 'badge-danger',
            self::SOLD_OUT => 'badge-info',
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
