<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class Items extends Component
{

    public $activeTab = 'giftCard';

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('livewire.frontend.items');
    }
}
