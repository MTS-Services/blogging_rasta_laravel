<?php

namespace App\Livewire\Backend\User\Profile;

use Livewire\Component;

class ProfileComponent extends Component
{

    public $activeTab = 'currency';
    public $reviewItem = 'all';

    public $activeInnerMenu = 'shop';
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function switchInnerMenu($menu)
    {
        $this->activeInnerMenu = $menu;
    }
    public function switchReviewItem($item)
    {
        $this->reviewItem = $item;
    }

    public function render()
    {
        return view('livewire.backend.user.profile.profile-component');
    }
}
