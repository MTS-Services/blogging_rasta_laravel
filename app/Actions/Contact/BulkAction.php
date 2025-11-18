<?php


namespace App\Actions\Contact;

use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    public function __construct(public ContactRepositoryInterface $interface) {}

    public function execute(array $ids, string $action, array $actioner, ?string $status = null)
    {
        return  DB::transaction(function () use ($ids, $action, $status, $actioner) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete(ids: $ids, actioner: $actioner);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete(ids: $ids);
                case 'restore':
                    return $this->interface->bulkRestore(ids: $ids, actioner: $actioner);
            }
        });
    }
}
