<?php

namespace App\Livewire\Frontend\Game\Currency;

use Livewire\Component;

class CurrencyShopComponent extends Component
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
        return view('livewire.frontend.game.currency.currency-shop-component');
    }
}
