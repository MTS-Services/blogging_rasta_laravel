<?php

namespace App\Actions\Product;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;

class RestoreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $interface
    ) {}

    public function execute(int $id, ?int $actionerId)
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
