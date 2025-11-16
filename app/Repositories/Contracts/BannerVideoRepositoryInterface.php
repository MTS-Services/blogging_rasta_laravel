<?php

namespace App\Repositories\Contracts;

use App\Models\BannerVideo;

interface BannerVideoRepositoryInterface
{
    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */
    public function getFirst(): ?BannerVideo;


    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */
    public function updateOrCreate(array $data, ?BannerVideo $exists = null): ?BannerVideo;
}
