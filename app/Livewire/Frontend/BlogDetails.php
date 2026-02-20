<?php

namespace App\Livewire\Frontend;

use App\Models\Blog;
use Livewire\Component;

class BlogDetails extends Component
{
    public Blog $data;
    public function mount(Blog $data): void
    {
        $data->load('category');
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.frontend.blog-details');
    }
}
