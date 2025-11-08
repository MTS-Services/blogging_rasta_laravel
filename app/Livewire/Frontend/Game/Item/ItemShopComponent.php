<?php

namespace App\Livewire\Frontend\Game\Item;

use Livewire\Component;

class ItemShopComponent extends Component
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
        return view('livewire.frontend.game.item.item-shop-component');
    }
}
