<?php

namespace App\Livewire\Backend\Admin\Blog;


use App\Models\Blog;
use Livewire\Component;

class View extends Component
{
    public Blog $model;
    public function mount(Blog $model): void
    {
        $this->model = $model;
    }
    public function render()
    {
        return view('livewire.backend.admin.blog.view');
    }
}
