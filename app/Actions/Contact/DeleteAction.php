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
        // dd($id , $forceDelete, $actionerId);
        return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $findData = null;

            if ($forceDelete) {
                $findData = $this->interface->findTrashed($id);
            } else {
                $findData = $this->interface->find($id);
            }

            if (!$findData) {
                throw new \Exception('Data not found');
            }
            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }
           return $this->interface->delete($id, [$actionerId]);
        });
    }
}
