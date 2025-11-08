<?php

namespace App\Repositories\Eloquent;

use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->orderBy($sortField, $order)->get();
    }

    public function getSellers(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->whereIn('user_type', [UserType::SELLER, UserType::BOTH])->orderBy($sortField, $order)->get();
    }

    public function getBuyers(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->model->whereIn('user_type', [UserType::BUYER, UserType::BOTH])->orderBy($sortField, $order)->get();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function trashPaginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        $query = $this->model->onlyTrashed();

        // Apply filters
        if (!empty($filters)) {
            $query->filter($filters);
        }

        // Apply sorting
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->paginate($perPage);
    }

    public function find(int $id): ?User
    {
        return $this->model->withTrashed()->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);

        if (!$user) {
            return false;
        }

        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);

        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    public function forceDelete(int $id): bool
    {
        $user = $this->model->onlyTrashed()->find($id);

        if (!$user) {
            return false;
        }

        return $user->forceDelete();
    }

    public function restore(int $id, $actioner_id): bool
    {
        $user = $this->model->withTrashed()->find($id);

        if (!$user) {
            return false;
        }

        $user->update(['restorer_id' => $actioner_id]);
        return $user->restore();
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

    public function getActive(): Collection
    {
        return $this->model->active()->get();
    }

    public function getInactive(): Collection
    {
        return $this->model->inactive()->get();
    }

    public function search(string $query): Collection
    {
        return $this->model->search($query)->get();
    }

    public function bulkDelete(array $ids, $actioner_id): int
    {
        $this->model->whereIn('id', $ids)->update(['deleter_id' => $actioner_id]);
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function bulkUpdateStatus(array $ids, string $status, $actioner_id): int
    {
        return $this->model->whereIn('id', $ids)->update(['account_status' => $status, 'updater_id' => $actioner_id]);
    }

    public function bulkRestore(array $ids, int $actioner_id): int
    {

        $this->model->onlyTrashed()->whereIn('id', $ids)->update(['restorer_id' => $actioner_id]);

        return $this->model->withTrashed()->whereIn('id', $ids)->restore();

    }

    public function bulkForceDelete(array $ids): int
    {
        return $this->model->withTrashed()->whereIn('id', $ids)->forceDelete();
    }
}
