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
        return $this->interface->all($sortfield, $order);
    }


    public function findData($column_value, string $column_name = 'id'): ?User
    {
        return $this->interface->find($column_value, $column_name);
    }


    public function getDataByEmail(string $email): ?User
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


    public function createData(array $data): User
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): User
    {
        return $this->updateAction->execute($id, $data);
    }

    public function deleteData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute($id, false, $actionerId);
    }

    public function restoreData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->restoreAction->execute($id, $actionerId);
    }

    public function forceDeleteData(int $id, ?int $actionerId = null): bool
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->deleteAction->execute($id, true, $actionerId);
    }

    public function updateStatusData(int $id, UserStatus $status, ?int $actionerId = null): User
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->updateAction->execute($id, [
            'status' => $status->value,
            'updated_by' => $actionerId,
        ]);
    }

    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {

        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute($ids, 'restore', null, $actionerId);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute($ids, 'forceDelete', null, $actionerId);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }

        return $this->bulkAction->execute($ids, 'delete', null, $actionerId);
    }

    public function bulkUpdateStatus(array $ids, UserStatus $status, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        return $this->bulkAction->execute(ids: $ids, action: 'status', status: $status->value, actionerId: $actionerId);
    }

    /* ================== ================== ==================
    *                   Accessors (optionals)
    * ================== ================== ================== */
}
