<?php


namespace App\Actions\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    public function __construct(public UserRepositoryInterface $interface) {}

    public function execute(array $ids, string $action, array $actioner, ?string $status = null)
    {
        return  DB::transaction(function () use ($ids, $action, $status, $actioner) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete(ids: $ids, actioner: $actioner);
                    break;
                case 'forceDelete':
                    return $this->interface->bulkForceDelete(ids: $ids);
                    break;
                case 'restore':
                    return $this->interface->bulkRestore(ids: $ids, actioner: $actioner);
                    break;
                case 'status':
                    return $this->interface->bulkUpdateStatus(ids: $ids, status: $status, actioner: $actioner);
                    break;
            }
        });
    }
}
