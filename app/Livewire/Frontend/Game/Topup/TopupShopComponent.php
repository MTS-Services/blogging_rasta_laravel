<?php

namespace App\Livewire\Frontend\Game\Topup;

use Livewire\Component;

class TopupShopComponent extends Component
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
        return view('livewire.frontend.game.topup.topup-shop-component');
    }
}
