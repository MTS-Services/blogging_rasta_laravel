<?php

namespace App\Actions\BlogCategory;

use App\Repositories\Contracts\BlogCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    public function __construct(
        protected BlogCategoryRepositoryInterface $interface
    ) {}

    public function execute(array $ids, string $action, int $actionerId): bool
    {
        return DB::transaction(function () use ($ids, $action, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids, $actionerId);
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids);
            }
            return false;
        });
    }
}
