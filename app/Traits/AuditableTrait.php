<?php

namespace App\Traits;

use OwenIt\Auditing\Auditable;

trait AuditableTrait
{
    use Auditable;

    /**
     * Should the timestamps be audited?
     */
    protected $auditTimestamps = false;

    /**
     * Generate tags for each audit
     */
    public function generateTags(): array
    {
        return [
            class_basename($this),
        ];
    }
}