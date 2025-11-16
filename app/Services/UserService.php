<?php

namespace App\Services;

use App\Actions\User\BulkAction;
use App\Actions\User\CreateAction;
use App\Actions\User\DeleteAction;
use App\Actions\User\RestoreAction;
use App\Actions\User\UpdateAction;

use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $interface,
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


    public function findData($column_value, string $column_name = 'id'): ?User
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


    public function createData(array $data): User
    {
        return $this->createAction->execute(data: $data);
    }

    public function updateData(int $id, array $data): User
    {
        return $this->updateAction->execute(id: $id, data: $data);
    }

    public function deleteData(int $id, array $actioner): bool
    {
        return $this->deleteAction->execute(id: $id, actioner: $actioner, forceDelete: false);
    }

    public function restoreData(int $id, array $actioner): bool
    {
        return $this->restoreAction->execute(id: $id, actioner: $actioner);
    }

    public function forceDeleteData(int $id): bool
    {
        $actioner = [
            'id' => null,
            'type' => null
        ];
        return $this->deleteAction->execute(id: $id, actioner: $actioner, forceDelete: true);
    }

    public function updateStatusData(int $id, UserStatus $status, array $actioner): User
    {
        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updater_id' => $actioner['id'],
            'updater_type' => $actioner['type']
        ]);
    }

    public function bulkRestoreData(array $ids, array $actioner): int
    {
        return $this->bulkAction->execute(ids: $ids, action: 'restore', actioner: $actioner, status: null);
    }

    public function bulkForceDeleteData(array $ids): int
    {
        $actioner = [
            'id' => null,
            'type' => null
        ];
        return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', actioner: $actioner, status: null);
    }

    public function bulkDeleteData(array $ids, array $actioner): int
    {
        return $this->bulkAction->execute(ids: $ids, action: 'delete', actioner: $actioner, status: null);
    }

    public function bulkUpdateStatus(array $ids, UserStatus $status, array $actioner): int
    {
        return $this->bulkAction->execute(ids: $ids, action: 'status', actioner: $actioner, status: $status->value);
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
