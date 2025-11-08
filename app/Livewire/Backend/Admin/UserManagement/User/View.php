<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use Livewire\Component;
use App\Services\UserService;

class View extends Component
{


    public $user;

    protected UserService $userService;
    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function render()
    {

        return view('livewire.backend.admin.user-management.user.view', [
            'user' => $this->user
        ]);
    }
}
