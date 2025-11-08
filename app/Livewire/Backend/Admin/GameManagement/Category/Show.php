<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use App\Models\GameCategory;
use Livewire\Component;

class Show extends Component
{
    public GameCategory $data;
    public function mount(GameCategory $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.category.show');
    }
}
