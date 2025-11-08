<?php

namespace App\Models;

use Carbon\Carbon;
use OwenIt\Auditing\Models\Audit as AuditModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Audit extends AuditModel
{
    protected $guarded = [];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    /**
     * Get the user that performed the audit (polymorphic)
     */
    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the auditable model
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get guard from user_type
     */
    public function getGuardAttribute(): ?string
    {
        if (!$this->user_type) {
            return null;
        }

        // Map model types to guards
        $guardMap = [
            'App\Models\User' => 'web',
            'App\Models\Admin' => 'admin',
        ];

        return $guardMap[$this->user_type] ?? null;
    }

    /**
     * Scope to filter by guard (using user_type)
     */
    public function scopeForGuard($query, string $guard)
    {
        $modelMap = [
            'web' => 'App\Models\User',
            'admin' => 'App\Models\Admin',
        ];

        $modelType = $modelMap[$guard] ?? null;

        if ($modelType) {
            return $query->where('user_type', $modelType);
        }

        return $query;
    }

    /**
     * Scope to filter by web guard (users)
     */
    public function scopeForUsers($query)
    {
        return $query->where('user_type', 'App\Models\User');
    }

    /**
     * Scope to filter by admin guard
     */
    public function scopeForAdmins($query)
    {
        return $query->where('user_type', 'App\Models\Admin');
    }

    /**
     * Get guard display name
     */
    public function getGuardDisplayNameAttribute(): string
    {
        return match ($this->user_type) {
            'App\Models\User' => 'User',
            'App\Models\Admin' => 'Admin',
            default => 'System',
        };
    }

    /**
     * Get formatted old values
     */
    public function getFormattedOldValuesAttribute()
    {
        return collect($this->old_values)->map(function ($value, $key) {
            return $this->formatValue($key, $value);
        });
    }

    /**
     * Get formatted new values
     */
    public function getFormattedNewValuesAttribute()
    {
        return collect($this->new_values)->map(function ($value, $key) {
            return $this->formatValue($key, $value);
        });
    }

    /**
     * Format value for display
     */
    protected function formatValue($key, $value)
    {
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        if (is_null($value)) {
            return 'N/A';
        }

        return $value;
    }

    /**
     * Get user name safely
     */
    public function getUserNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name ?? $this->user->email ?? 'Unknown User';
        }

        return 'System';
    }

    /**
     * Get user email safely
     */
    public function getUserEmailAttribute(): ?string
    {
        return $this->user?->email;
    }

    /**
     * Check if audit was performed by admin
     */
    public function isAdminAction(): bool
    {
        return $this->user_type === 'App\Models\Admin';
    }

    /**
     * Check if audit was performed by regular user
     */
    public function isUserAction(): bool
    {
        return $this->user_type === 'App\Models\User';
    }

    /**
     * Check if audit was performed by system
     */
    public function isSystemAction(): bool
    {
        return is_null($this->user_id);
    }

    /**
     * Get the model namespace for a guard
     */
    public static function getModelForGuard(string $guard): ?string
    {
        $modelMap = [
            'web' => 'App\Models\User',
            'admin' => 'App\Models\Admin',
        ];

        return $modelMap[$guard] ?? null;
    }

    /**
     * Get the guard for a model
     */
    public static function getGuardForModel(string $modelType): ?string
    {
        $guardMap = [
            'App\Models\User' => 'web',
            'App\Models\Admin' => 'admin',
        ];

        return $guardMap[$modelType] ?? null;
    }


    /* ================================================================
    * *** PROPERTIES ***
    ================================================================ */

    protected $appends = [
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


    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('event', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->search($search);
        });

        return $query;
    }

}
