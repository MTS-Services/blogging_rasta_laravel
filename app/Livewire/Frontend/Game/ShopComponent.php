<?php

namespace App\Livewire\Frontend\Game;

use Livewire\Component;

class ShopComponent extends Component
{

    public $gameSlug;
    public $categorySlug;
   

    public function mount($gameSlug, $categorySlug)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.shop-component');
    }
}
