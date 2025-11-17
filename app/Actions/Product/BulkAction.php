<?php

namespace App\Actions\Product;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $interface
    ) {}

    public function execute(array $ids, string $action, ?string $status = null, ?int $actionerId)
    {
        return  DB::transaction(function () use ($ids, $action, $status, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                case 'status':
                    return $this->interface->bulkUpdateStatus($ids, $status, $actionerId);
            }
        });
    }
}
