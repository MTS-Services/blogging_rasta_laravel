<?php

namespace App\Livewire\Backend\User\Partials;

use Livewire\Component;

class Sidebar extends Component
{
    public string $pageSlug;
    public string $breadcrumb;

    public function mount(string $pageSlug = 'home', string $breadcrumb = '')
    {
        $this->pageSlug = $pageSlug;
        $this->breadcrumb = $breadcrumb;
    }
    
    public function render()
    {
        return view('backend.user.layouts.partials.sidebar');
    }
}
