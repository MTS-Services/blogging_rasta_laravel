<?php

namespace App\Livewire\Frontend;

use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public function mount(): void
    {
        /** @var User $user */
        $user = auth()->user();
        if (! $user) {
            $this->redirect(route('login'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.frontend.user-profile', [
            'user' => auth()->user(),
        ]);
    }
}
