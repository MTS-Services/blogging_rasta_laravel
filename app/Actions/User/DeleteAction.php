<?php

namespace App\Actions\User;

// use App\Events\Admin\AdminDeleted;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(public UserRepositoryInterface $interface) {}

    public function execute(int $id, array $actioner,  bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($id, $actioner, $forceDelete) {

            $model = null;

            if ($forceDelete) {
                $model = $this->interface->findTrashed(column_value: $id);
            } else {
                $model = $this->interface->find(column_value: $id);
            }

            if (!$model) {
                throw new \Exception('User not found');
            }

            // Dispatch event before deletion
            // event(new AdminDeleted($admin));

            if ($forceDelete) {
                // Delete avatar
                if ($model->avatar) {
                    Storage::disk('public')->delete($model->avatar);
                }

                return $this->interface->forceDelete(id: $id);
            }

            return $this->interface->delete(id: $id, actioner: $actioner);
        });
    }
}
