<?php

namespace App\Actions\TikTokUser;

use App\Models\TikTokUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\TikTokUserRepositoryInterface;

class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected TikTokUserRepositoryInterface $interface
    ) {
    }

    public function execute(int $id, array $data): TikTokUser
    {
        return DB::transaction(function () use ($id, $data) {
            $findData = $this->interface->find($id);
            if (!$findData) {
                Log::error('Data not found', ['data_id' => $id]);
                throw new \Exception('Data not found');
            }
            $updated = $this->interface->update($id, $data);
            if (!$updated) {
                Log::error('Failed to update data in repository', ['data_id' => $id]);
                throw new \Exception('Failed to update data');
            }
            return $findData->fresh();
        });
    }
}
