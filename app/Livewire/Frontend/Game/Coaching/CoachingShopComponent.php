<?php

namespace App\Livewire\Frontend\Game\Coaching;

use Livewire\Component;

class CoachingShopComponent extends Component
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
        return view('livewire.frontend.game.coaching.coaching-shop-component');
    }
}
