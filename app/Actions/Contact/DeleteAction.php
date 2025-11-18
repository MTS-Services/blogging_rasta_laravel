<?php

namespace App\Actions\Contact;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ContactRepositoryInterface;

class DeleteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ContactRepositoryInterface $interface
    ) {}

    public function execute(int $id, bool $forceDelete = false, int $actionerId): bool
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

           return $this->interface->delete($id, $actionerId);
        });
    }
}
