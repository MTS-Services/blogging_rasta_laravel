<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class CurrencyComponent extends Component
{
    public function render()
    {

        $pagination = [
            'total' => 100,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 11,
            'from' => 1,
            'to' => 2,
        ];
        return view('livewire.frontend.currency-component',[
            'pagination' => $pagination,
        ]);
    }
}
