<?php

namespace App\Livewire\Backend\Admin\AdminManagement\Admin;

use App\Models\Admin;
use Livewire\Component;

class View extends Component
{

    public Admin $data;
    public function mount(Admin $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.admin-management.admin.view');
    }
}
