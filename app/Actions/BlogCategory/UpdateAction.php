<?php

namespace App\Actions\BlogCategory;

use App\Models\BlogCategory;
use App\Repositories\Contracts\BlogCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction
{
    public function __construct(
        protected BlogCategoryRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): BlogCategory
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->interface->find($id);
            if (! $findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception('Data not found');
            }
            $updated = $this->interface->update($id, $data);
            if (! $updated) {
                Log::error('Failed to update data in repository', ['data_id' => $id]);
                throw new \Exception('Failed to update data');
            }
            return $findData->fresh();
        });
    }
}
