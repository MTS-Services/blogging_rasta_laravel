<?php

namespace App\Livewire\Backend\Admin\TikTokManagement\UserCategory;

use App\Models\UserCategory;
use Livewire\Component;

class Show extends Component
{
    public UserCategory $data;
    public function mount(UserCategory $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.tik-tok-management.user-category.show');
    }
}
