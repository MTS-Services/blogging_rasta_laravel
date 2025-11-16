<?php

namespace App\Services;

use App\Models\BannerVideo;
use App\Actions\BannerVideo\CreateOrUpdateAction;
use App\Repositories\Contracts\BannerVideoRepositoryInterface;

class BannerVideoService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected BannerVideoRepositoryInterface $interface,
        protected CreateOrUpdateAction $createOrUpdateAction
    ) {}



    public function getFirstData(): ?BannerVideo
    {
        return $this->interface->getFirst();
    }



    public function createOrUpdateData(array $data): ?BannerVideo
    {
        return $this->createOrUpdateAction->execute($data);
    }
}
