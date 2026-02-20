<?php

namespace App\Actions\BlogCategory;

use App\Models\BlogCategory;
use App\Repositories\Contracts\BlogCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected BlogCategoryRepositoryInterface $interface
    ) {}

    public function execute(array $data): BlogCategory
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
