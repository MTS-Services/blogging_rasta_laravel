<?php

namespace App\Livewire\Backend\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;

class View extends Component
{ public Contact $data;
    public function mount(Contact $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.contact.view');
    }
}
