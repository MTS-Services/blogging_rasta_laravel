<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ProductRepositoryInterface $interface
    ) {}

    public function execute(array $data): Product
    {
        return DB::transaction(function () use ($data) {

            if ($data['image']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['image']->getClientOriginalName();
                $data['image'] = Storage::disk('public')->putFileAs('products',  $data['image'], $fileName);
            }

            // Create user
            $model = $this->interface->create($data);

            return $model->fresh();
        });
    }
}
