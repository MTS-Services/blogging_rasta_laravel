<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class BaseModel extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait, Searchable;

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
     |  Relationships
     ================================================================ */


    public function creater_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by')->select(['id', 'name', 'status']);
    }

    public function updater_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by')->select(['id', 'name', 'status']);
    }

    public function deleter_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'deleted_by')->select(['id', 'name', 'status']);
    }
    public function restorer_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'restored_by')->select(['id', 'name', 'status']);
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
     |  Accessors
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
        return $this->restored_at ? dateTimeHumanFormat($this->attributes['restored_at']) : null;
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
    public function getRestoredAtFormattedAttribute(): ?string
    {
        return $this->restored_at ? dateTimeFormat($this->attributes['restored_at']) : null;
    }
}
