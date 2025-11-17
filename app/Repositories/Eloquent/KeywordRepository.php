<?php

namespace App\Repositories\Eloquent;


use App\Models\Keyword;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Contracts\KeywordRepositoryInterface;

class KeywordRepository implements KeywordRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Keyword $model
    )
    {}


    /* ================== ================== ==================
    *                      Find Methods
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id',  bool $trashed = false): ?Keyword
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function findTrashed($column_value, string $column_name = 'id'): ?Keyword
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
            return Keyword::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Paginate only trashed records with optional search.
     */
    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // 👇 Manually filter trashed + search
            return Keyword::search($search)
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

    public function create(array $data): Keyword
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $findData = $this->find($id);

        if (!$findData) {
            return false;
        }

        return $findData->update($data);
    }

    public function delete(int $id, int $actionerId): bool
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

    public function restore(int $id, int $actionerId): bool
    {
        $findData = $this->findTrashed($id);

        if (!$findData) {
            return false;
        }
        $findData->update(['restored_by' => $actionerId, 'restored_at' => now()]);

        return $findData->restore();
    }

    public function bulkDelete(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->whereIn('id', $ids)->update(['deleted_by' => $actionerId]);
            return $this->model->whereIn('id', $ids)->delete();
        });
    }

    public function bulkRestore(array $ids, int $actionerId): int
    {
        return DB::transaction(function () use ($ids, $actionerId) {
            $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restored_by' => $actionerId, 'restored_at' => now()]);
            return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
        });
    }
    public function bulkForceDelete(array $ids): int //
    {
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }

    /* ================== ================== ==================
    *                  Accessor Methods (Optional)
    * ================== ================== ================== */
}
