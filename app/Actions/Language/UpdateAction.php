<?php

namespace App\Actions\Language;

use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateAction
{
    public function __construct(
        protected LanguageRepositoryInterface $interface
    ) {}

    public function execute(int $id, array $data): Language
    {
        return DB::transaction(function () use ($id, $data) {

            // Fetch Language
            $findData = $this->interface->find($id);

            if (!$findData) {
                Log::error('Data not found', ['language_id' => $id]);
                throw new \Exception('Language not found');
            }

            $oldData = $findData->getAttributes();

            // Update Language
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Data', ['language_id' => $id]);
                throw new \Exception('Failed to update Data');
            }

            // Refresh model
            $findData = $findData->fresh();

            // Detect changes
            $changes = [];
            foreach ($findData->getAttributes() as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            return $findData;
        });
    }
}
