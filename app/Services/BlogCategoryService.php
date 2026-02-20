<?php

namespace App\Services;

use App\Actions\BlogCategory\BulkAction;
use App\Actions\BlogCategory\CreateAction;
use App\Actions\BlogCategory\DeleteAction;
use App\Actions\BlogCategory\RestoreAction;
use App\Actions\BlogCategory\UpdateAction;
use App\Models\BlogCategory;
use App\Repositories\Contracts\BlogCategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BlogCategoryService
{
    public function __construct(
        protected BlogCategoryRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction,
    ) {}

    /* ================== ================== ==================
     *                          Find Methods
     * ================== ================== ================== */

    public function getAllDatasWithCount($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->allWithCount($sortField, $order);
    }

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?BlogCategory
    {
        return $this->interface->find($column_value, $column_name);
    }

    public function getActiveCategories(): Collection
    {
        return $this->interface->getActiveOrderedByTitle();
    }

    public function findActiveBySlug(string $slug): ?BlogCategory
    {
        return $this->interface->findActiveBySlug($slug);
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

    public function createData(array $data): BlogCategory
    {
        return $this->createAction->execute($data);
    }

    public function updateData(int $id, array $data): BlogCategory
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

    public function bulkRestoreData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        $this->bulkAction->execute(ids: $ids, action: 'restore', actionerId: $actionerId);
        return count($ids);
    }

    public function bulkForceDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        $this->bulkAction->execute(ids: $ids, action: 'forceDelete', actionerId: $actionerId);
        return count($ids);
    }

    public function bulkDeleteData(array $ids, ?int $actionerId = null): int
    {
        if ($actionerId == null) {
            $actionerId = admin()->id;
        }
        $this->bulkAction->execute(ids: $ids, action: 'delete', actionerId: $actionerId);
        return count($ids);
    }
}
