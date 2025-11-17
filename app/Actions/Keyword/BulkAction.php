<?php

namespace App\Actions\Keyword;

use App\Repositories\Contracts\KeywordRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected KeywordRepositoryInterface $interface
    )
    {}


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
        });
    }
}
