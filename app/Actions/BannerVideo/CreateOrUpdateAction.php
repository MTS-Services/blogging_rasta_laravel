<?php

namespace App\Actions\BannerVideo;

use App\Models\BannerVideo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repositories\Contracts\BannerVideoRepositoryInterface;


class CreateOrUpdateAction
{
    public function __construct(protected BannerVideoRepositoryInterface $interface) {}

    public function execute(int $id, array $data): BannerVideo
    {
        // 1. Initialize variables to track newly uploaded files for rollback
        $newSingleAvatarPath = null;
        $uploadedPaths = []; // Multiple avatar paths
        return DB::transaction(function () use ($id, $data, &$newSingleAvatarPath, &$uploadedPaths) {



            $bannerVideo = $id ? $this->interface->first() : null;

            if (!$bannerVideo) {
                Log::error('bannerVideo not found', ['bannerVideo_id' => $id]);
                throw new \Exception('Data not found');
            }

            $oldData = $bannerVideo->getAttributes();
            $newData = $data;

            // --- 1. Single Avatar Handling ---
            $oldAvatarPath = Arr::get($oldData, 'thumbnail');
            $uploadedAvatar = Arr::get($data, 'thumbnail');

            if ($uploadedAvatar instanceof UploadedFile) {
                // Delete old file permanently (File deletion is non-reversible)
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                // Store the new file and track path for rollback
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedAvatar->getClientOriginalName();

                $newSingleAvatarPath = Storage::disk('public')->putFileAs('banner_video', $uploadedAvatar, $fileName);
                $newData['thumbnail'] = $newSingleAvatarPath;
            } elseif (Arr::get($data, 'remove_file')) {
                if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                $newData['thumbnail'] = null;
            }
            // Cleanup temporary/file object keys
            if (!$newData['remove_file'] && !$newSingleAvatarPath) {
                $newData['thumbnail'] = $oldAvatarPath ?? null;
            }
            // unset($newData['remove_file']);

           
            if (!isset($newData['remove_file']) || !$newData['remove_file']) {
                if (!$newSingleAvatarPath) {
                    $newData['thumbnail'] = $oldAvatarPath ?? null;
                }
            }

        
            $newData = Arr::except($newData, ['remove_file']);


            return $this->interface->updateOrCreate($newData);
        });
    }
}
