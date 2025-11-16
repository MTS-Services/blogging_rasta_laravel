<?php

namespace App\Services;

use App\Models\BannerVideo;
use App\Actions\BannerVideo\CreateOrUpdateAction;
use App\Repositories\Eloquent\BannerVideoRepository;

class BannerVideoService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected BannerVideoRepository $interface,
        protected CreateOrUpdateAction $createOrUpdateAction
    ) {}




    public function getData(array $requestData): BannerVideo
    {
        return $this->interface->updateOrCreate($requestData);
    }



    public function createOrUpdateData(array $data): BannerVideo
    {
        // প্রথম রেকর্ডের ID খুঁজে নিন
        $record = $this->interface->first();
        
        // যদি রেকর্ড থাকে তাহলে তার ID, না হলে 0 (নতুন তৈরি করার জন্য)
        $id = $record ? $record->id : 0;
        
        // Action এ ID সহ pass করুন
        return $this->createOrUpdateAction->execute($id, $data);
    }
}
