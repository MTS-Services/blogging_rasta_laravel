<?php

namespace App\Actions\UserCategory;

use App\Models\UserCategory;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\UserCategoryRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserCategoryRepositoryInterface $interface
    )
    {}

    public function execute(array $data): UserCategory
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
