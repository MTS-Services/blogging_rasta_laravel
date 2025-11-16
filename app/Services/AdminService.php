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
        return $this->interface->all(sortField: $sortfield, order: $order);
    }


    public function findData($column_value, string $column_name = 'id'): ?Admin
    {
        return $this->interface->find(column_value: $column_value, column_name: $column_name);
    }


    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate(perPage: $perPage, filters: $filters);
    }


    public function getTrashedPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate(perPage: $perPage, filters: $filters);
    }

    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->search(query: $query, sortField: $sortField, order: $order);
    }

    public function dataExists(int $id): bool
    {
        return $this->interface->exists(id: $id);
    }

    public function getDataCount(array $filters = []): int
    {
        return $this->interface->count(filters: $filters);
    }

    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */


    public function createData(array $data): Admin
    {
        return $this->createAction->execute(data: $data);
    }

    public function updateData(int $id, array $data): Admin
    {
        return $this->updateAction->execute(id: $id, data: $data);
    }

    public function deleteData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute(id: $id, forceDelete: false, actionerId: $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->restoreAction->execute(id: $id, actionerId: $actionerId);
    }

    public function forceDeleteData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute(id: $id, forceDelete: true, actionerId: $actionerId);
    }

    public function updateStatusData(int $id, AdminStatus $status, ?int $actionerId = null): Admin
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute(id: $id,  data: [
            'status' => $status->value,
            'updated_by' => $actionerId,
        ]);
    }

    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {

        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute(ids: $ids,  action: 'restore', status: null, actionerId: $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actionerId);
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
}
