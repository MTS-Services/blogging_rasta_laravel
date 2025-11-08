<?php

namespace App\Repositories\Eloquent;

use App\Models\Audit;
use App\Repositories\Contracts\AuditRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AuditRepository implements AuditRepositoryInterface
{
    public function __construct(
        protected Audit $model
    ) {}
 
    public function all(string $sortField = 'created_at' , $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }
 
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();
        if (!empty($filters)) {
            $query->filter($filters);
        }
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
 
        return $query->paginate($perPage);
    }
 
    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->onlyTrashed()->orderBy('deleted_at', 'desc');
        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }
 
        // Apply sorting        
        $sortField = $filters['sort_field'] ?? 'deleted_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);
 
        return $query->paginate($perPage);
    }
 
    public function find($column_value, string $column_name = 'id',  bool $trashed = false): ?Audit
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }
 
    public function findTrashed($column_value, string $column_name = 'id'): ?Audit
    {
        $model = $this->model->onlyTrashed();
        return $model->where($column_name, $column_value)->first();
    }
    public function delete(int $id): bool
    {
        $data = $this->find($id);
       
        if (!$data) {
            return false;
        }
 
        return $data->delete();
    }
 
    public function forceDelete(int $id): bool
    {
        $data = $this->findTrashed($id);
       
        if (!$data) {
            return false;
        }
 
        return $data->forceDelete();
    }
 
    public function restore(int $id): bool
    {
        $data = $this->findTrashed($id);
       
        if (!$data) {
            return false;
        }
 
        return $data->restore();
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
 
    public function search(string $query, string $sortField = 'created_at' , $order = 'desc'): Collection
    {
        return $this->model->search($query)->orderBy($sortField, $order)->get();
    }
 
    public function bulkDelete(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
    public function bulkRestore(array $ids): int
    {
         return $this->model->onlyTrashed()->whereIn('id', $ids)->restore();
    }
    public function bulkForceDelete(array $ids): int //
    {  
        return $this->model->onlyTrashed()->whereIn('id', $ids)->forceDelete();
    }
}
