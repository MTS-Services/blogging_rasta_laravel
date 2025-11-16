<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use Livewire\Component;

class View extends Component
{
    public User $model;
    public function mount(User $model): void
    {
        $this->model = $model;
    }
}
