<?php


namespace App\Actions\Contact;

use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BulkAction
{
    public function __construct(public ContactRepositoryInterface $interface) {}

    public function execute(array $ids, string $action, ?int $actionerId = null)
    {
        return  DB::transaction(function () use ($ids, $action, $actionerId) {
            switch ($action) {
                case 'delete':
                    return $this->interface->bulkDelete($ids,  $actionerId);
                case 'forceDelete':
                    return $this->interface->bulkForceDelete($ids, );
                case 'restore':
                    return $this->interface->bulkRestore($ids, $actionerId);
            }
        });
    }
}
