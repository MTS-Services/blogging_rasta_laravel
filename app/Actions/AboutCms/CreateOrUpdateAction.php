<?php

namespace App\Actions\AboutCms;

use App\Models\AboutCms;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repositories\Contracts\AboutCmsRepositoryInterface;


class CreateOrUpdateAction
{
    public function __construct(protected AboutCmsRepositoryInterface $interface)
    {
    }

    public function execute(array $data): AboutCms
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
                $newFilePath = Storage::disk('public')->putFileAs('about_videos', $uploadedFile, $fileName);
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
            return $this->interface->updateOrCreate($newData, $exists);
        });
    }
}
