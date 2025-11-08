<?php

namespace App\Livewire\Backend\Admin\UserManagement\User\Profile;

use App\Models\User;
use Livewire\Component;

class Referral extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user->load(['referral']);
    }
    public function render()
    {
        return view('livewire.backend.admin.user-management.user.profile.referral');
    }
}
