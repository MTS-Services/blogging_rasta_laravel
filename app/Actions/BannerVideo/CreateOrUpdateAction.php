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
    public function __construct(protected BannerVideoRepositoryInterface $interface)
    {
    }

    public function execute(array $data): BannerVideo
    {

        return DB::transaction(function () use ($data) {

            $oldData = [];
            $exists = $this->interface->getFirst();
            if ($exists) {
                $data['updated_by'] = admin()->id;
                $oldData = $exists->getAttributes();
            } else {
                $data['created_by'] = admin()->id;
            }
            $newData = $data;


            // File
            $oldFilePath = Arr::get($oldData, 'banner_video');
            $uploadedFile = Arr::get($data, 'banner_video');
            $newFilePath = null;
            if ($uploadedFile instanceof UploadedFile) {
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedFile->getClientOriginalName();
                $newFilePath = Storage::disk('public')->putFileAs('banner_videos', $uploadedFile, $fileName);
                $newData['banner_video'] = $newFilePath;
            } elseif (Arr::get($data, 'removeBannerVideo')) {
                if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
                $newData['banner_video'] = null;
            }


            if (!$newData['removeBannerVideo'] && !$newFilePath) {
                $newData['banner_video'] = $oldFilePath ?? null;
            }
            unset($newData['removeBannerVideo']);

            // Thumbnail
            $oldThumbnailPath = Arr::get($oldData, 'thumbnail');
            $uploadedThumbnail = Arr::get($data, 'thumbnail');
            $newThumbnailPath = null;
            if ($uploadedThumbnail instanceof UploadedFile) {
                if ($oldThumbnailPath && Storage::disk('public')->exists($oldThumbnailPath)) {
                    Storage::disk('public')->delete($oldThumbnailPath);
                }
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $uploadedThumbnail->getClientOriginalName();
                $newThumbnailPath = Storage::disk('public')->putFileAs('banner_videos', $uploadedThumbnail, $fileName);
                $newData['thumbnail'] = $newThumbnailPath;
            } elseif (Arr::get($data, 'removeThumbnail')) {
                if ($oldThumbnailPath && Storage::disk('public')->exists($oldThumbnailPath)) {
                    Storage::disk('public')->delete($oldThumbnailPath);
                }
                $newData['thumbnail'] = null;
            }


            if (!$newData['removeThumbnail'] && !$newThumbnailPath) {
                $newData['thumbnail'] = $oldThumbnailPath ?? null;
            }
            unset($newData['removeThumbnail']);



            return $this->interface->updateOrCreate($newData, $exists);
        });
    }
}
