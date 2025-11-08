<?php

namespace App\Livewire\Frontend\Game;

use Livewire\Component;

class CheckoutComponent extends Component
{

    public $gameSlug;
    public $categorySlug;
    public $sellerSlug;

    public function mount($gameSlug, $categorySlug, $sellerSlug)
    {
        $this->gameSlug = $gameSlug;
        $this->categorySlug = $categorySlug;
        $this->sellerSlug = $sellerSlug;
    }
    public function render()
    {
        return view('livewire.frontend.game.checkout-component');
    }
}
