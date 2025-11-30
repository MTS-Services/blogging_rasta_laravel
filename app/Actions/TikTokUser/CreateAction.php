<?php

namespace App\Actions\TikTokUser;

use App\Models\TikTokUser;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\TikTokUserRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected TikTokUserRepositoryInterface $interface
    ) {
    }

    public function execute(array $data): TikTokUser
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
