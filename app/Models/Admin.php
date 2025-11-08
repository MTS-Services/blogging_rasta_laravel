<?php

namespace App\Models;

use App\Enums\AdminStatus;
use App\Enums\OtpType;
use App\Models\AuthBaseModel;
use App\Traits\AuditableTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

class Admin extends AuthBaseModel implements Auditable
{
    use TwoFactorAuthenticatable, AuditableTrait, Searchable;
    
    protected $guard = 'admin';

    protected $fillable = [
        'sort_order',
        'name',
        'email',
        'email_verified_at',
        'two_factor_confirmed_at',
        'phone',
        'phone_verified_at',
        'password',
        'avatar',
        'status',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'last_login_at',
        'last_login_ip',

        

        'created_by',
        'updated_by',
        'deleted_by',


    ];


    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

 
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_synced_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'status' => AdminStatus::class,
            'two_factor_confirmed_at' => 'datetime',
        ];
    }


/* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    //

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */


 /* 
    =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |           Query Scopes                                       |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#=
 */



    public function scopeActive($query)
    {
        return $query->where('status', AdminStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', AdminStatus::INACTIVE);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        });

 

        return $query;
    }
 /* 
    =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |          End of Query Scopes                                       |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#=
 */

    
 /* 
    =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |          Scout Search Configuration                                    |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#=
 */

    #[SearchUsingPrefix([ 'name', 'email', 'phone', 'status'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
        ];
    }

    /**
     * Include only non-deleted data in search index.
     */
    public function shouldBeSearchable(): bool
    {
        return is_null($this->deleted_at);
    }

 /*
    =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |        End  Scout Search Configuration                                    |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#=
 */



     /*
    =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |        Attribute Accessors                                    |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#=
 */

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }

      /*
    =#=#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
    |       Methods                                   |
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=#=
 */
    public function isActive(): bool
    {
        return $this->status === AdminStatus::ACTIVE;
    }

    public function activate(): void
    {
        $this->update(['status' => AdminStatus::ACTIVE]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => AdminStatus::INACTIVE]);
    }

    public function suspend(): void
    {
        $this->update(['status' => AdminStatus::SUSPENDED]);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }



    public function otpVerifications()
    {
        return $this->morphMany(OtpVerification::class, 'verifiable');
    }

    /**
     * Get the latest OTP verification of a specific type.
     */
    public function latestOtp(OtpType $type)
    {
        return $this->otpVerifications()
            ->where('type', $type)
            ->latest()
            ->first();
    }

    /**
     * Create a new OTP verification.
     */
    public function createOtp(OtpType $type, int $expiresInMinutes = 10): OtpVerification
    {
        // Invalidate old OTPs of same type
        $this->otpVerifications()
            ->where('type', $type)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        $otp = sprintf('%06d', mt_rand(0, 999999));

        return $this->otpVerifications()->create([
            'type' => $type,
            'code' => $otp,
            'expires_at' => now()->addMinutes($expiresInMinutes),
            'attempts' => 0,
        ]);
    }

    /**
     * Mark email as verified.
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    /**
     * Mark phone as verified.
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => now(),
        ])->save();
    }
}
