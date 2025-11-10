<?php

namespace App\Services;

use App\Repositories\Contracts\AuditRepositoryInterface;
use App\Actions\Audit\DeleteAction;
use App\Models\Audit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuditService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AuditRepositoryInterface $interface,
        protected DeleteAction $deleteAction,
    )
    {}

   public function getAll($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }
 
    public function getPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->paginate($perPage, $filters);
    }
 
    public function findData($column_value, string $column_name = 'id'): ?Audit
    {
        return $this->interface->find($column_value, $column_name);
    }
    public function deleteData(int $id, bool $forceDelete = false): bool
    {
        return $this->deleteAction->execute($id, $forceDelete);
    }
 
    public function restoreData(int $id): bool
    {
        return $this->deleteAction->restore($id);
    }
 
    public function searchData(string $query, $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->search($query, $sortField, $order);
    }
 
    public function bulkDeleteData(array $ids): int
    {
        return $this->interface->bulkDelete($ids);
    }
 
    public function getDataCount(array $filters = []): int
    {
        return $this->interface->count($filters);
    }
 
    public function dataExists(int $id): bool
    {
        return $this->interface->exists($id);
    }
    public function getTrashedDataPaginated(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->interface->trashPaginate($perPage, $filters);
    }
 
    public function bulkRestoreData(array $ids): int
    {
        return $this->interface->bulkRestore($ids);
    }
 
    public function bulkForceDeleteData(array $ids): int
    {
        return $this->interface->bulkForceDelete($ids);
    }
}
