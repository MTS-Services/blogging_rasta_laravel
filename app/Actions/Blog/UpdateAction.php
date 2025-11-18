<?php

namespace App\Actions\Blog;


use App\Events\Admin\AdminUpdated;
use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateAction
{
    public function __construct(public BlogRepositoryInterface $interface) {}

    public function execute(int $id,  array $data): Blog
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->interface->find($id);

            if (!$model) {
                Log::error('Data not found', ['blog_id' => $id]);
                throw new \Exception('Blog not found');
            }
            $oldData = $model->getAttributes();
            $newData = $data;

            $oldAvatarPath = Arr::get($oldData, 'file');
            $uploadedAvatar = Arr::get($data, 'file');
            $newSingleAvatarPath = null;

            if ($uploadedAvatar instanceof UploadedFile) {
                // Delete old file permanently (File deletion is non-reversible)
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }

                // Store the new file and track path for rollback
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

                $newSingleAvatarPath = Storage::disk('public')->putFileAs('blogs', $uploadedAvatar, $fileName);
                $newData['file'] = $newSingleAvatarPath;
            } elseif (Arr::get($data, 'remove_file')) {
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                $newData['file'] = null;
            }

            if (!$newData['remove_file'] && !$newSingleAvatarPath) {
                $newData['file'] = $oldAvatarPath ?? null;
            }

            unset($newData['remove_file']);


            // Update Admin
            $updated = $this->interface->update($id, $newData);

            if (!$updated) {
                Log::error('Failed to update Data in repository', ['blog_id' => $id]);
                throw new \Exception('Failed to update Blog');
            }

            // Refresh the Blog model
            $model = $model->fresh();

            return $model;
        });
    }
}
