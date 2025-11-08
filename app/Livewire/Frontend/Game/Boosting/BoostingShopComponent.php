<?php

namespace App\Livewire\Frontend\Game\Boosting;

use Livewire\Component;

class BoostingShopComponent extends Component
{

    public $gameSlug;
    public $gameName;
    
    public function mount($gameSlug)
    {
        $this->gameSlug = $gameSlug;
        $this->gameName = ucwords(str_replace('-', ' ', $gameSlug));
    }
    public function render()
    {
        return view('livewire.frontend.game.boosting.boosting-shop-component');
    }
}
