<?php

namespace App\Repositories\Contracts;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface
{

    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection;

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?Admin;

    public function findByEmail(string $email, bool $trashed = false): ?Admin;

    public function findTrashed($column_value, string $column_name = 'id'): ?Admin;

    public function findTrashedByEmail(string $email): ?Admin;

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    public function exists(int $id): bool;

    public function count(array $filters = []): int;

    public function search(string $query, string $sortField = 'created_at', $order = 'desc'): Collection;


    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */


    public function create(array $data): Admin;

    public function update(int $id, array $data): bool;

    public function delete(int $id, $actionerId): bool;

    public function forceDelete(int $id): bool;

    public function restore(int $id, int $actionerId): bool;

    public function bulkDelete(array $ids, int $actionerId): int;

    public function bulkUpdateStatus(array $ids, string $status, $actionerId): int;

    public function bulkRestore(array $ids, int $actionerId): int;

    public function bulkForceDelete(array $ids): int;

    /* ================== ================== ==================
    *                  Accessor Methods (Optional)
    * ================== ================== ================== */

    public function getActive(string $sortField = 'created_at', $order = 'desc'): Collection;

    public function getInactive(string $sortField = 'created_at', $order = 'desc'): Collection;

    public function getPending(string $sortField = 'created_at', $order = 'desc'): Collection;

    public function getSuspended(string $sortField = 'created_at', $order = 'desc'): Collection;
}
