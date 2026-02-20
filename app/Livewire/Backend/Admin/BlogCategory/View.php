<?php

namespace App\Livewire\Backend\Admin\BlogCategory;

use App\Models\BlogCategory;
use Livewire\Component;

class View extends Component
{
    public BlogCategory $data;

    public function mount(BlogCategory $data): void
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.backend.admin.blog-category.view');
    }
}
