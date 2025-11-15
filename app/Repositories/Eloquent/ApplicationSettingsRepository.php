<?php

namespace App\Repositories\Eloquent;

use App\Models\ApplicationSetting;
use App\Repositories\Contracts\ApplicationSettingsIntarface;
use Pest\Support\Str;

class ApplicationSettingsRepository implements ApplicationSettingsIntarface
{
    public function __construct(protected ApplicationSetting $model) {}
    public function find($key, ?string $default = null): ?string
    {
        $row = $this->model->where('key', $key)->first();
        return $row ? $row->value : $default;
    }
}
