<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class Header extends Component
{
    public string $pageSlug;

    public function mount(string $pageSlug = 'home')
    {
        $this->pageSlug = $pageSlug;
    }
    public function render()
    {
        return view('livewire.frontend.partials.header');
    }
}
