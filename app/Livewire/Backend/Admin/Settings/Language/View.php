<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\Models\Language;
use Livewire\Component;

class View extends Component
{
    public Language $language;
    public function mount(Language $language): void
    {
        $this->language = $language;
    }
    public function render()
    {
        return view('livewire.backend.admin.settings.language.view');
    }
}
