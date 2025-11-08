<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class AdminRepository implements AdminRepositoryInterface
{
    public function __construct(
        protected Admin $model
    ) {}

    

    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {

        $query = $this->model->query();

        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Admin
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    
    public function findTrashed($column_value, string $column_name = 'id'): ?Admin
    {
        $model = $this->model->onlyTrashed();

        return $model->where($column_name, $column_value)->first();

    }



 
    public function findByEmail(string $email, $trashed = false): ?Admin
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where('email', $email)->first();
    }

    public function findTrashedByEmail(string $email): ?Admin
    {
        return $this->model->onlyTrashed()->where('email', $email)->first();
    }

    
        public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // Scout Search
            return Admin::search($search)
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
            return Admin::search($search)
                ->onlyTrashed()
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->onlyTrashed()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
        return $query->paginate($perPage);
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



    public function create(array $data): Admin
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $admin = $this->find($id);
        
        if (!$admin) {
            return false;
        }

        return $admin->update($data);
    }



    public function delete(int $id, $actionerId): bool
    {
        $admin = $this->find($id);
        
        if (!$admin) {
            return false;
        }

        $admin->update(['deleter_id' => $actionerId]);

        return $admin->delete();
    }

    public function forceDelete(int $id): bool
    {
        $admin = $this->findTrashed($id);
        
        if (!$admin) {
            return false;
        }

        return $admin->forceDelete();
    }

    public function restore(int $id, int $actionerId): bool
    {
        $admin = $this->findTrashed($id);
        
        if (!$admin) {
            return false;
        }
        $admin->update(['restorer_id' => $actionerId]);

        return $admin->restore();
    }


    public function bulkUpdateStatus(array $ids, string $status, $actionerId): int
    {

        return $this->model->withTrashed()->whereIn('id', $ids)->update(['status' => $status, 'updater_id' => $actionerId]);
    }

    public function bulkRestore(array $ids, int $actionerId): int
    {

            $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_id' => $actionerId]);

            return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();

    }

    public function bulkDelete(array $ids, int $actionerId): int{
        
         $this->model->whereIn('id', $ids)->update(['deleter_id' => $actionerId]);

         return $this->model->whereIn('id', $ids)->delete();
    }
    public function bulkForceDelete(array $ids): int //
    {  
        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }




    /* ================== ================== ==================
    *                  Accessor Methods (Optional)
    * ================== ================== ================== */



    public function getActive(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->active()->orderBy($sortField, $order)->get();
    }

    public function getInactive(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->inactive()->orderBy($sortField, $order)->get();
    }


    public function getPending(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->pending()->orderBy($sortField, $order)->get();
    }

    public function getSuspended(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->suspended()->orderBy($sortField, $order)->get();
    }



}