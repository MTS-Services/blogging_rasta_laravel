<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Models\Game;
use Livewire\Component;

class Show extends Component
{


    public Game $data;
    public function mount(Game $data)
    {

        $this->data = $data->load('category');
    }
    public function render()
    {

        return view('livewire.backend.admin.game-management.game.show');
    }
}
