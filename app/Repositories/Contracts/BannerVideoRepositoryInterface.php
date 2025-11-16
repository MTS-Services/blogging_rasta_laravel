<?php

namespace App\Repositories\Contracts;

use App\Models\BannerVideo;

interface BannerVideoRepositoryInterface
{
    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */
    public function first(): ?BannerVideo;


    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */
    public function updateOrCreate(array  $data): BannerVideo;

    public function update(int $id, array $data): bool;
}
