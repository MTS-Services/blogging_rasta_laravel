<?php

namespace App\Services;

use App\Actions\Admin\BulkAction;
use App\Actions\Admin\CreateAction;
use App\Actions\Admin\DeleteAction;
use App\Actions\Admin\RestoreAction;
use App\Actions\Admin\UpdateAction;

use App\Enums\AdminStatus;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AdminService
{
    public function __construct(
        protected AdminRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction,
    ) {}

    /* ================== ================== ==================
    *                          Find Methods 
    * ================== ================== ================== */

    public function getAllDatas($sortfield = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortfield, $order);
    }


   public function findData($column_value, string $column_name = 'id'): ?Admin
    {
      return $this->interface->find($column_value, $column_name);
    }


    public function getDataByEmail(string $email): ?Admin
    {
        return $this->interface->findByEmail($email);
    }


    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }

    
    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }

     public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->search($query, $sortField, $order);
    }
    
     public function dataExists(int $id): bool
    {
        return $this->interface->exists($id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }


    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */


    public function createData(array $data): Admin
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): Admin
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, bool $forceDelete = false, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->deleteAction->execute($id, $forceDelete, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->restoreAction->execute($id, $actionerId);
    }
   public function updateStatusData(int $id, AdminStatus $status, ?int $actionerId = null): Admin
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updated_by' => $actionerId,
        ]);
    }



    public function bulkRestoreData(array $ids, ? int $actionerId = null): int
    {

        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute($ids, 'restore', null, $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if($actionerId == null){
          $actionerId = admin()->id;
        }

        return $this->bulkAction->execute($ids, 'forceDelete', null, $actionerId);
    }


    
    public function bulkDeleteData(array $ids , ?int $actionerId = null): int
    {
        if($actionerId == null){
          $actionerId = admin()->id; 
        }

        return $this->bulkAction->execute($ids, 'delete', null, $actionerId);
    }



    public function bulkUpdateStatus(array $ids, AdminStatus $status, ?int $actionerId = null): int
    {

 

        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'status', status: $status->value, actionerId: $actionerId);
    }

    /* ================== ================== ==================
    *                   Accessors (optionals)
    * ================== ================== ================== */


    public function getActiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getActive($sortField, $order);
    }

    public function getInactiveData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getInactive($sortField, $order);
    }

    public function getSuspendedData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getSuspended($sortField, $order);
    }

    public function getPendingData($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->getPending($sortField, $order);
    }


}
