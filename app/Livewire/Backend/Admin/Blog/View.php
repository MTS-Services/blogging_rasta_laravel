<?php

namespace App\Livewire\Backend\Admin\Blog;


use App\Models\Blog;
use Livewire\Component;

class View extends Component
{
    public Blog $data;
    public function mount(Blog $data): void
    {
        $data->load(['comments' => fn ($q) => $q->with('user:id,name,avatar')->latest()]);
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.blog.view');
    }
}
