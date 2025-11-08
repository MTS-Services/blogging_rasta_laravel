<?php

namespace App\Livewire\Backend\Admin\Partials;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public string $active = '';

    public function mount(string $active)
    {
        $this->active = $active;
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
        return view('backend.admin.layouts.partials.sidebar');
    }
}
