<?php
 
namespace App\Enums;
 
enum userKycStatus: string
{
    case PENDING = 'pending';
    case SUBMMITTED = 'submitted';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
 
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Active',
            self::SUBMMITTED => 'Submitted',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::PENDING => 'badge-warning',
            self::SUBMMITTED => 'badge-info',
            self::APPROVED => 'badge-success',
            self::REJECTED => 'badge-danger',
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