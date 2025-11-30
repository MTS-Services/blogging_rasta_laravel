<?php

namespace App\Actions\TikTokUser;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TikTokUserRepositoryInterface;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected TikTokUserRepositoryInterface $interface
    )
    {}

    public function execute(array $ids, string $action, ?string $status = null, int $actionerId): bool
    {
        return DB::transaction(function () use ($ids, $action, $status, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                case 'status':
                    return $this->interface->bulkUpdateStatus($ids, $status, $actionerId);
            }
        });
    }
}
