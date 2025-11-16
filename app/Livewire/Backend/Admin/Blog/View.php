<?php

namespace App\Livewire\Backend\Admin\Blog;


use App\Models\Admin;
use Livewire\Component;

class View extends Component
{
    public Admin $model;
    public function mount(Admin $model): void
    {
        $this->model = $model;
    }
    // public function render()
    // {
    //     return view('livewire.backend.admin.user-management.admin.view');
    // }
}
