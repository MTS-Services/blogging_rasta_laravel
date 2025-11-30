<?php

namespace App\Services;

use App\Models\UserCategory;
use App\Enums\UserUserCategoryStatus;
use App\Actions\UserCategory\BulkAction;
use App\Actions\UserCategory\CreateAction;
use App\Actions\UserCategory\DeleteAction;
use App\Actions\UserCategory\UpdateAction;
use App\Actions\UserCategory\RestoreAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\UserCategoryRepositoryInterface;

class UserCategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserCategoryRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction
    ) {}

    /* ================== ================== ==================
    *                          Find Methods
    * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?UserCategory
    {
        return $this->interface->find($column_value, $column_name);
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

    public function createData(array $data): UserCategory
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): UserCategory
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

    public function updateStatusData(int $id, UserCategoryStatus $status, ?int $actionerId = null): UserCategory
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
        return $this->bulkAction->execute(ids: $ids, action: 'restore', status: null, actionerId: $actionerId);
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
    public function bulkUpdateStatus(array $ids, UserCategoryStatus $status, ?int $actionerId = null): int
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
