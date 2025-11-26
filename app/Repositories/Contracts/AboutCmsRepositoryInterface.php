<?php

namespace App\Repositories\Contracts;

use App\Models\AboutCms;

interface AboutCmsRepositoryInterface
{

    /* ================== ================== ==================
     *                      Find Methods
     * ================== ================== ================== */
    public function getFirst(): ?AboutCms;


    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */
    public function updateOrCreate(array $data, ?AboutCms $exists = null): ?AboutCms;
}
