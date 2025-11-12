<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use Livewire\Component;

class View extends Component
{
    public User $data;
    public function mount(User $data): void
    {
        $this->data = $data;
    }
}
