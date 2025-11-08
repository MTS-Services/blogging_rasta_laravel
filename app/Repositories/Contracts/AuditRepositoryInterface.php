<?php

namespace App\Repositories\Contracts; 

use App\Models\Audit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
 
interface AuditRepositoryInterface
{
 
    public function all(string $sortField = 'created_at' , $order = 'desc'): Collection;
 
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
 
    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
 
    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Audit;
 
    public function findTrashed( $column_value, string $column_name = 'id'): ?Audit;
   
    public function delete(int $id): bool;
 
    public function forceDelete(int $id): bool;
 
    public function restore(int $id): bool;
 
    public function exists(int $id): bool;
 
    public function count(array $filters = []): int;
 
    public function search(string $query, string $sortField = 'created_at' , $order = 'desc'): Collection;
 
    public function bulkDelete(array $ids): int;
 
    public function bulkRestore(array $ids): int;
 
    public function bulkForceDelete(array $ids): int;
}
