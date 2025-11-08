<?php

namespace App\Livewire\Backend\Admin\ReviewManagement\PageView;

use App\Models\PageView;
use Livewire\Component;

class Show extends Component
{
     public PageView $data;
    public function mount(PageView $data): void
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.backend.admin.review-management.page-view.show');
    }
}
