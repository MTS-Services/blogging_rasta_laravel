<?php

namespace App\Livewire\Backend\Admin\Keyword;

use App\Models\Keyword;
use Livewire\Component;

class View extends Component
{
    public Keyword $data;
    public function mount (Keyword $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.keyword.view');
    }
}
