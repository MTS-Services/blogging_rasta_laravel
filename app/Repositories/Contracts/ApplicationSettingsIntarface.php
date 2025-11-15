<?php

namespace App\Repositories\Contracts;

use App\Models\ApplicationSetting;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationSettingsIntarface
{
     public function find($key, ?string $default = null): ?string;
}