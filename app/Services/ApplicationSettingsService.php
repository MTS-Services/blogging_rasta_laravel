<?php

namespace App\Services;

use App\Models\ApplicationSetting;
use App\Repositories\Contracts\ApplicationSettingsIntarface;

class ApplicationSettingsService
{
    public function __construct(
        protected ApplicationSettingsIntarface $interface,
    ) {}

    public function findData($key, ?string $default = null): ?string
    {
        return $this->interface->find($key, $default);
    }
}