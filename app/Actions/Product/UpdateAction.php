<?php

namespace App\Actions\Product;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repositories\Contracts\ProductRepositoryInterface;

class UpdateAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ProductRepositoryInterface $interface
    ) {}



    public function execute(int $id,  array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->interface->find($id);

            if (!$model) {
                Log::error('Data not found', ['product_id' => $id]);
                throw new \Exception('Product not found');
            }
            $oldData = $model->getAttributes();
            $newData = $data;

            $oldAvatarPath = Arr::get($oldData, 'image');
            $uploadedAvatar = Arr::get($data, 'image');

            if ($uploadedAvatar instanceof UploadedFile) {
                // Delete old file permanently (File deletion is non-reversible)
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }

                // Store the new file and track path for rollback
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

                $newSingleAvatarPath = Storage::disk('public')->putFileAs('products', $uploadedAvatar, $fileName);
                $newData['image'] = $newSingleAvatarPath;
            } elseif (Arr::get($data, 'remove_image')) {
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                $newData['image'] = null;
            }
            unset($newData['remove_image']);


            // Update Admin
            $updated = $this->interface->update($id, $newData);

            if (!$updated) {
                Log::error('Failed to update Data in repository', ['product_id' => $id]);
                throw new \Exception('Failed to update Product');
            }

            // Refresh the Product model
            $model = $model->fresh();

            return $model;
        });
    }
}
