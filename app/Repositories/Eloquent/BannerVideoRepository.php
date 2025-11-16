<?php

namespace App\Repositories\Eloquent;

use App\Models\BannerVideo;
use App\Repositories\Contracts\BannerVideoRepositoryInterface;



class BannerVideoRepository implements BannerVideoRepositoryInterface
{
    public function __construct(protected BannerVideo $model) {}


    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */
    public function getFirst(): ?BannerVideo
    {
        return $this->model->first();
    }

    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */
    public function updateOrCreate(array $data, ?BannerVideo $exists = null): BannerVideo
    {
        if ($exists) {
            $exists->update($data);
            return $exists;
        } else {
            return $this->model->create($data);
        }
    }
}
