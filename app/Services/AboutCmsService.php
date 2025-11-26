<?php

namespace App\Services;

use App\Actions\AboutCms\CreateOrUpdateAction;
use App\Models\AboutCms;
use App\Repositories\Contracts\AboutCmsRepositoryInterface;



class AboutCmsService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AboutCmsRepositoryInterface $interface,
        protected CreateOrUpdateAction $createOrUpdateAction
    ) {}



    public function getFirstData(): ?AboutCms
    {
        return $this->interface->getFirst();
    }



    public function createOrUpdateData(array $data): ?AboutCms
    {
        return $this->createOrUpdateAction->execute($data);
    }
}
