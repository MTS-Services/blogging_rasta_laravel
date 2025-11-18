<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class ContactRepository implements ContactRepositoryInterface
{
    public function __construct(protected Contact $model) {}
    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {

        $query = $this->model->query();

        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Contact
    {

        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }


    public function findTrashed($column_value, string $column_name = 'id'): ?Contact
    {
        $model = $this->model->onlyTrashed();

        return $model->where($column_name, $column_value)->first();
    }


    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // Scout Search
            return Contact::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }


    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // 👇 Manually filter trashed + search
            return Contact::search($search)
                ->onlyTrashed()
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->onlyTrashed()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }


    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    public function count(array $filters = []): int
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->count();
    }

    public function search(string $query, string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->search($query)->orderBy($sortField, $order)->get();
    }


    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */




    public function delete(int $id, $actionerId): bool
    {
        $findData = $this->find($id);

        if (!$findData) {
            return false;
        }
        $findData->update(['deleted_by' => $actionerId]);
        return $findData->delete();
    }

    public function forceDelete(int $id): bool
    {
        $findData = $this->findTrashed($id);

        if (!$findData) {
            return false;
        }

        return $findData->forceDelete();
    }

    public function restore(int $id, array $actioner): bool
    {
        $findData = $this->findTrashed(column_value: $id);

        if (!$findData) {
            return false;
        }
        $findData->update(['restorer_id' => $actioner['id'], 'restorer_type' => $actioner['type'], 'restored_at' => now(), 'deleter_id' => null, 'deleter_type' => null]);
        return $findData->restore();
    }


    public function bulkRestore(array $ids, array $actioner): int
    {

        $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_id' => $actioner['id'], 'restorer_type' => $actioner['type'], 'restored_at' => now(), 'deleter_id' => null, 'deleter_type' => null]);
        return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
    }

    public function bulkDelete(array $ids, array $actioner): int
    {

        $this->model->whereIn('id', $ids)->update(['deleter_id' => $actioner['id'], 'deleter_type' => $actioner['type']]);

        return $this->model->whereIn('id', $ids)->delete();
    }
    public function bulkForceDelete(array $ids): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }
}
