<?php

namespace App\Actions\Admin;

use App\Events\Admin\AdminDeleted;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(public AdminRepositoryInterface $interface) {}

    public function execute(int $id, bool $forceDelete = false, $actionerId): bool
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $model = null;
            if ($forceDelete) {
                $model = $this->interface->findTrashed(column_value: $id);
            } else {
                $model = $this->interface->find(column_value: $id);
            }

            if (!$model) {
                throw new \Exception('Admin not found');
            }

            // Dispatch event before deletion
            event(new AdminDeleted($model));

            if ($forceDelete) {
                // Delete avatar
                if ($model->avatar) {
                    Storage::disk('public')->delete($model->avatar);
                }

                return $this->interface->forceDelete($id);
            }

            return $this->interface->delete($id, $actionerId);
        });
    }
}
