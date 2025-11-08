<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Attributes\Url;
use Livewire\Component;

class SearchModal extends Component
{
    #[Url('globalSearch')]
    public $search;

    public function render()
    {
        return view('livewire.frontend.partials.search-modal');
    }
}
