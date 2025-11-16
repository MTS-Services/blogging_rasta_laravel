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
    public function first(): ?BannerVideo
    {
        return $this->model->first();
    }




    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */
    public function updateOrCreate(array $data): BannerVideo
    {
        $firstRecord = $this->first();

        if ($firstRecord) {

            return $this->model->updateOrCreate(
                ['id' => $firstRecord->id],
                $data
            );
        } else {

            return $this->model->create($data);
        }
    }


    public function update(int $id, array $data): bool
    {
        $record = $this->model->find($id);

        if (!$record) {
            return false;
        }

        return $record->update($data);
    }
}
