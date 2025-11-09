<?php

namespace App\Livewire\Backend\Admin\UserManagement\Admin;

use App\Models\Admin;
use Livewire\Component;

class View extends Component
{
    public Admin $data;
    public function mount(Admin $data): void
    {
        $this->data = $data;
    }
}
