<?php

namespace App\Repositories\Eloquent;

use App\Models\AboutCms;
use App\Repositories\Contracts\AboutCmsRepositoryInterface;

class AboutCmsRepository implements AboutCmsRepositoryInterface
{
    public function __construct(protected AboutCms $model) {}


    /* ================== ================== ==================
    *                      Find Methods
    * ================== ================== ================== */
    public function getFirst(): ?AboutCms
    {
        return $this->model->first();
    }

    /* ================== ================== ==================
    *                    Data Modification Methods
    * ================== ================== ================== */
    public function updateOrCreate(array $data, ?AboutCms $exists = null): AboutCms
    {
        if ($exists) {
            $exists->update($data);
            return $exists;
        } else {
            return $this->model->create($data);
        }
    }
}
