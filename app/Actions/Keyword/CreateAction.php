<?php

namespace App\Actions\Keyword;

use App\Models\Keyword;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\KeywordRepositoryInterface;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected KeywordRepositoryInterface $interface
    ) {}

    public function execute(array $data): Keyword
    {
        return DB::transaction(function () use ($data) {
            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
}
