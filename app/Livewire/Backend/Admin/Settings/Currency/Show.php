<?php

namespace App\Livewire\Backend\Admin\Settings\Currency;

use App\Models\Currency;
use Livewire\Component;

class Show extends Component
{
    public Currency $data;
    public function mount(Currency $data): void
    {
        $this->data = $data;
    }
}
