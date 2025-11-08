<?php

namespace App\Livewire\Frontend\Game\Account;

use Livewire\Component;

class AccountShopComponent extends Component
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
        return view('livewire.frontend.game.account.account-shop-component');
    }
}
