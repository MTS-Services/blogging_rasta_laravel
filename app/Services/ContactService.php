<?php

namespace App\Services;

use App\Actions\Contact\BulkAction;
use App\Actions\Contact\DeleteAction;
use App\Actions\Contact\RestoreAction;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    public function __construct(
        protected ContactRepositoryInterface $interface,
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


    public function findData($column_value, string $column_name = 'id'): ?Contact
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

}
