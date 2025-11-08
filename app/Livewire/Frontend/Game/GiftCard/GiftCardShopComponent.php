<?php

namespace App\Livewire\Frontend\Game\GiftCard;

use Livewire\Component;

class GiftCardShopComponent extends Component
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
        return view('livewire.frontend.game.gift-card.gift-card-shop-component');
    }
}
