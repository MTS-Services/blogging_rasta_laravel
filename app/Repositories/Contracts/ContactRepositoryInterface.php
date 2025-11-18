<?php

namespace App\Repositories\Contracts;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ContactRepositoryInterface
{

    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection;

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Contact;

    public function findTrashed($column_value, string $column_name = 'id'): ?Contact;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function exists(int $id): bool;

    public function count(array $filters = []): int;

    public function search(string $query, string $sortField = 'created_at', $order = 'desc'): Collection;


    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */



    public function delete(int $id, array $actioner): bool;

    public function forceDelete(int $id): bool;

    public function restore(int $id, array $actioner): bool;

    public function bulkDelete(array $ids, array $actioner): int;

    public function bulkRestore(array $ids, array $actioner): int;

    public function bulkForceDelete(array $ids): int;

}
