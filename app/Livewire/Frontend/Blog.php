<?php

namespace App\Livewire\Frontend;

use App\Enums\BlogStatus;
use App\Services\BlogService;
use Livewire\Component;

class Blog extends Component
{
    protected BlogService $blogService;

    public function boot(BlogService $service)
    {
        $this->blogService = $service;
    }

    public function render()
    {
        $blogs = $this->blogService->getPaginatedData(
            filters: $this->getFilters()
        );
        return view('livewire.frontend.blog', compact('blogs'));
    }

    protected function getFilters()
    {
        return [
            'status' => BlogStatus::PUBLISHED->value,
        ];
    }
}
