<?php

namespace App\Models;

use App\Enums\OtpType;
use App\Enums\UserType;
use App\Enums\UserStatus;
use App\Enums\userKycStatus;
use App\Traits\AuditableTrait;
use Illuminate\Support\Carbon;
use App\Enums\UserAccountStatus;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends AuthBaseModel implements Auditable
{
    use  TwoFactorAuthenticatable, AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sort_order',
        'country_id',

        'username',
        'first_name',
        'last_name',
        'email',

        'apple_id',
        'facebook_id',
        'google_id',
        'avatar',
        'date_of_birth',

        'timezone',
        'language',
        'currency',


        'email_verified_at',
        'password',

        'phone',
        'phone_verified_at',

        'user_type',
        'account_status',

        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',

        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',

        'terms_accepted_at',
        'privacy_accepted_at',

        'last_synced_at',
        'language_id',

        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',
        'restorer_id',


    ];

    protected $auditExclude = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    /**
     * Audits relationship
     */
    public function audits(): MorphMany
    {
        return $this->morphMany(Audit::class, 'user');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'      => 'datetime',
            'phone_verified_at'      => 'datetime',
            'otp_expires_at'         => 'datetime',
            'last_login_at'          => 'datetime',
            'locked_until'           => 'datetime',
            'terms_accepted_at'      => 'datetime',
            'privacy_accepted_at'    => 'datetime',
            'last_synced_at'         => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'date_of_birth'          => 'date',

            'two_factor_enabled'     => 'boolean',
            'password'               => 'hashed',

            'user_type'              => UserType::class,
            'account_status'         => UserAccountStatus::class,
            'kyc_status'             => userKycStatus::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function seller(): HasOne
    {
        return $this->hasOne(SellerProfile::class, 'user_id', 'id');
    }
    public function statistic(): HasOne
    {
        return $this->hasOne(UserStatistic::class, 'user_id', 'id');
    }
    public function referral(): HasOne
    {
        return $this->hasOne(UserReferral::class, 'user_id', 'id');
    }
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    public function userReferral(): HasOne
    {
        return $this->hasOne(UserReferral::class, 'user_id', 'id');
    }
    public function sellerProduct(): HasOne
    {
        return $this->hasOne(Product::class, 'user_id', 'id');
    }
    public function productReview(): HasOne 
    {
        return $this->hasOne(Product::class, 'user_id', 'id');
    }

    public function userBans(): HasMany
    {
        return $this->hasMany(UserBan::class, 'user_id', 'id');
    }
    public function bandedBy(): HasMany
    {
        return $this->hasMany(User::class, 'banned_by', 'id');
    }
    public function unbandedBy(): HasMany
    {
        return $this->hasMany(User::class, 'unbanned_by', 'id');
    }
    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', UserAccountStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', UserAccountStatus::INACTIVE);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('username', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status));
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));
        $query->when($filters['user_type'] ?? null, fn($q, $type) => $q->where('user_type', $type));
        $query->when($filters['account_status'] ?? null, fn($q, $acc) => $q->where('account_status', $acc));

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->account_status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->account_status->color();
    }

    public function getUserTypeLabelAttribute(): string
    {
        return $this->user_type->label();
    }

    public function getUserTypeColorAttribute(): string
    {
        return $this->user_type->color();
    }

    public function getAccountStatusLabelAttribute(): string
    {
        return $this->account_status->label();
    }

    public function getAccountStatusColorAttribute(): string
    {
        return $this->account_status->color();
    }

    public function getAvatarUrlAttribute(): string
    {
        $name = $this->display_name ?? $this->full_name ?? $this->username;
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($name);
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === UserStatus::ACTIVE;
    }

    public function activate(): void
    {
        $this->update(['status' => UserStatus::ACTIVE]);
    }

    public function deactivate(): void
    {
        $this->update(['status' => UserStatus::INACTIVE]);
    }

    public function suspend(): void
    {
        $this->update(['status' => UserStatus::SUSPENDED]);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->appends = array_merge(parent::getAppends(), [
            'full_name',
            'avatar_url',
            'status_label',
            'status_color',
            'user_type_label',
            'user_type_color',
            'account_status_label',
            'account_status_color',
        ]);
    }

    /**
     * Get all OTP verifications for the user.
     */

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
