<?php

namespace App\Models;

use App\Enums\OtpType;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class OtpVerification extends BaseModel implements Auditable
{
    use  AuditableTrait;
     protected $fillable = [
        'sort_order',
        'verifiable_type',
        'verifiable_id',
        'type',
        'code',
        'expires_at',
        'attempts',
        'verified_at',

        'creater_type',
        'updater_type',
        'deleter_type',
        
        'creator_id',
        'updater_id',
        'deleter_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'type'=>OtpType::class,
    ];

    /**
     * Polymorphic relationship.
     */
    public function verifiable()
    {
        return $this->morphTo();
    }

    /**
     * Check if OTP is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if OTP is verified.
     */
    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    /**
     * Verify OTP code.
     */
    public function verify(string $code): bool
    {
        if ($this->isExpired() || $this->isVerified()) {
            return false;
        }

        if ($this->code === $code) {
            $this->update(['verified_at' => now()]);
            return true;
        }

        $this->increment('attempts');
        return false;
    }
}
