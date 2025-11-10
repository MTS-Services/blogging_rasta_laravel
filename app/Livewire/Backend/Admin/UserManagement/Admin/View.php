<?php

namespace App\Livewire\Backend\Admin\UserManagement\Admin;

use App\Models\Admin;
use Livewire\Component;

class View extends Component
{
    public Admin $model;

    public function mount(Admin $model): void
    {
        $this->model = $model;
    }
}
