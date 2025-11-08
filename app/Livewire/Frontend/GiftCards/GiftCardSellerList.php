<?php

namespace App\Livewire\Frontend\GiftCards;

use Livewire\Component;

class GiftCardSellerList extends Component
{
    public $activeTab = 'giftCard';

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('livewire.frontend.gift-cards.gift-card-seller-list');
    }
}
