<?php

namespace App\Actions\Blog;

use App\Events\Admin\AdminDeleted;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(public BlogRepositoryInterface $interface) {}

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
                throw new \Exception('Data not found');
            }


            if ($forceDelete) {
                // Delete file
                if ($model->file) {
                    Storage::disk('public')->delete($model->file);
                }

                return $this->interface->forceDelete($id);
            }

            return $this->interface->delete($id, $actionerId);
        });
    }
}
