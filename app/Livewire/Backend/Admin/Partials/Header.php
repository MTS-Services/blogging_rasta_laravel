<?php

namespace App\Livewire\Backend\Admin\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public string $breadcrumb = '';
    public function mount(string $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }


    public function render()
    {
        return view('backend.admin.layouts.partials.header');
    }
}
