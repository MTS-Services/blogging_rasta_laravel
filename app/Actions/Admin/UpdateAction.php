<?php

namespace App\Actions\Admin;


use App\Events\Admin\AdminUpdated;
use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    public function __construct(public AdminRepositoryInterface $interface) {}

    // public function execute(int $id,  array $data): Admin
    // {
    //     return DB::transaction(function () use ($id, $data) {

    //         $model = $this->interface->find($id);

    //         if (!$model) {
    //             Log::error('Admin not found', ['admin_id' => $id]);
    //             throw new \Exception('Admin not found');
    //         }
    //          $oldData = $model->getAttributes();
    //         $newData = $data;

    //         $oldAvatarPath = Arr::get($oldData, 'avatar');
    //         $uploadedAvatar = Arr::get($data, 'avatar');
    //         $newSingleAvatarPath = null;


    //         if ($uploadedAvatar instanceof UploadedFile) {
    //             // Delete old file permanently (File deletion is non-reversible)
    //             if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
    //                 Storage::disk('public')->delete($oldAvatarPath);
    //             }

    //             // Store the new file and track path for rollback
    //             $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
    //             $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

    //             $newSingleAvatarPath = Storage::disk('public')->putFileAs('admins', $uploadedAvatar, $fileName);
    //             $newData['avatar'] = $newSingleAvatarPath;
    //         } elseif (Arr::get($data, 'remove_file')) {
    //             if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
    //                 Storage::disk('public')->delete($oldAvatarPath);
    //             }
    //             $newData['avatar'] = null;
    //         }

    //         if (!$newData['remove_file'] && !$newSingleAvatarPath) {
    //             $newData['avatar'] = $oldAvatarPath ?? null;
    //         }

    //         unset($newData['remove_file']);

    //         $newData['password'] = $newData['password'] ?? $model->password;

    //         // Update Admin
    //         $updated = $this->interface->update($id, $newData);

    //         if (!$updated) {
    //             Log::error('Failed to update Admin in repository', ['admin_id' => $id]);
    //             throw new \Exception('Failed to update Admin');
    //         }

    //         // Refresh the Admin model
    //         $model = $model->fresh();

    //         event(new AdminUpdated($model, $newData));

    //         return $model;
    //     });
    // }
     public function execute(int $id, array $data): Admin
    {
        // 1. Initialize variables to track newly uploaded files for rollback
        $newSingleAvatarPath = null;
        $uploadedPaths = []; // Multiple avatar paths

        try {
            // Start the database transaction
            return DB::transaction(function () use ($id, $data, &$newSingleAvatarPath ) {
                $admin = $this->interface->find($id);
                
                if (!$admin) {
                    Log::error('Admin not found', ['admin_id' => $id]);
                    throw new \Exception('Data not found');
                }
                $oldData = $admin->getAttributes();
                $newData = $data;
                // --- 1. Single Avatar Handling ---
                $oldAvatarPath = Arr::get($oldData, 'avatar');
                $uploadedAvatar = Arr::get($data, 'avatar');
                if ($uploadedAvatar instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                        Storage::disk('public')->delete($oldAvatarPath);
                    }
                    // Store the new file and track path for rollback
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

                    $newSingleAvatarPath = Storage::disk('public')->putFileAs('admins', $uploadedAvatar, $fileName);
                    $newData['avatar'] = $newSingleAvatarPath;
                } elseif (Arr::get($data, 'remove_file')) {
                    if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                        Storage::disk('public')->delete($oldAvatarPath);
                    }
                    $newData['avatar'] = null;
                }
                // Cleanup temporary/file object keys
                if (!$newData['remove_file'] && !$newSingleAvatarPath) {
                    $newData['avatar'] = $oldAvatarPath ?? null;
                }
                unset($newData['remove_file']);

                // --- 2. Password Handling ---
                $newPassword = Arr::get($data, 'password');
                if (!empty($newPassword)) {
                    $newData['password'] = Hash::make($newPassword);
                } else {
                    unset($newData['password']);
                }
           
                // --- 4. Update Admin ---
                Log::info('Data sent to repository', ['data' => $newData]);
                $updated = $this->interface->update($id, $newData);

                if (!$updated) {
                    throw new \Exception('Failed to update Data');
                }

                // Refresh model and dispatch event
                $admin = $admin->fresh();
                $newAttributes = $admin->getAttributes();
                $changes = [];

                foreach ($newAttributes as $key => $value) {
                    if (in_array($key, ['created_at', 'updated_at', 'id'])) continue;
                    $oldValue = Arr::get($oldData, $key);
                    if ($oldValue !== $value) {
                        $changes[$key] = ['old' => $oldValue, 'new' => $value];
                    }
                }

                if (!empty($changes)) {
                    event(new AdminUpdated($admin, $changes));
                }

                return $admin;
            });
        } catch (\Exception $e) {
            // --- FILE ROLLBACK MECHANISM: Delete files uploaded in this transaction ---

            // 1. Rollback single avatar file
            if ($newSingleAvatarPath && Storage::disk('public')->exists($newSingleAvatarPath)) {
                Storage::disk('public')->delete($newSingleAvatarPath);
                Log::warning('File Rollback: Deleted single new avatar file.', ['path' => $newSingleAvatarPath]);
            }

            // 2. Rollback multiple avatar files
            if (!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
                Log::warning('File Rollback: Deleted ' . count($uploadedPaths) . ' new multiple avatar files.');
            }

            // Re-throw the exception to communicate failure
            throw $e;
        }
    }
}
