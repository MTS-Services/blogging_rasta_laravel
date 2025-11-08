<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthBaseModel extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    /* ================================================================
     * *** PROPERTIES ***
     ================================================================ */

    protected $appends = [
        'modified_image',

        'verify_label',
        'verify_color',

        'created_at_human',
        'updated_at_human',
        'deleted_at_human',
        'restored_at_human',

        'created_at_formatted',
        'updated_at_formatted',
        'deleted_at_formatted',
        'restored_at_formatted',
    ];

    /* ================================================================
     * *** Relations ***
     ================================================================ */

    public function creater_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id')->select(['name', 'id', 'status']);
    }

    public function updater_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id')->select(['name', 'id', 'status']);
    }

    public function deleter_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'deleted_by', 'id')->select(['name', 'id', 'status']);
    }
    public function restorer_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'restored_by', 'id')->select(['name', 'id', 'status']);
    }

    public function creater(): MorphTo
    {
        return $this->morphTo();
    }

    public function updater(): MorphTo
    {
        return $this->morphTo();
    }

    public function deleter(): MorphTo
    {
        return $this->morphTo();
    }
    public function restorer(): MorphTo
    {
        return $this->morphTo();
    }

    /* ================================================================
     * *** Accessors ***
     ================================================================ */

    public function getCreatedAtHumanAttribute(): string
    {
        return dateTimeHumanFormat($this->attributes['created_at']);
    }

    public function getUpdatedAtHumanAttribute(): string
    {
        return dateTimeHumanFormat($this->attributes['updated_at'], $this->attributes['created_at']);
    }

    public function getDeletedAtHumanAttribute(): ?string
    {
        return dateTimeHumanFormat($this->attributes['deleted_at']);
    }
    public function getRestoredAtHumanAttribute(): ?string
    {
        return dateTimeHumanFormat($this->attributes['restored_at']);
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['created_at']);
    }

    public function getUpdatedAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['updated_at'], $this->attributes['created_at']);
    }

    public function getDeletedAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['deleted_at']);
    }
    public function getRestoredAtFormattedAttribute(): string
    {
        return dateTimeFormat($this->attributes['restored_at']);
    }

    // Verify Accessors
    public function getVerifyLabelAttribute()
    {
        return $this->email_verified_at ? 'Verified' : 'Unverified';
    }

    public function getVerifyColorAttribute()
    {
        return $this->email_verified_at ? 'badge-success' : 'badge-error';
    }

    public function getModifiedImageAttribute()
    {
        return auth_storage_url($this->image);
    }

    /* ================================================================
     * *** Scopes ***
     ================================================================ */

    // Verified scope
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    /* ================================================================
     * *** Mutators ***
     ================================================================ */

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
