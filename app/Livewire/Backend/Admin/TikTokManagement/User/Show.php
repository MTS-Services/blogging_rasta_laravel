<?php

namespace App\Livewire\Backend\Admin\TikTokManagement\User;

use App\Models\TikTokUser;
use Livewire\Component;

class Show extends Component
{
    public TikTokUser $data;
    public function mount(TikTokUser $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.user.show');
    }
}
