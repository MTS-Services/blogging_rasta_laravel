<?php

namespace App\Livewire\Frontend;

use App\Enums\BlogStatus;
use App\Services\BlogCategoryService;
use App\Services\BlogService;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

    protected BlogService $blogService;

    protected BlogCategoryService $blogCategoryService;

    public function boot(BlogService $blogService, BlogCategoryService $blogCategoryService)
    {
        $this->blogService = $blogService;
        $this->blogCategoryService = $blogCategoryService;
    }

    public function render()
    {
        $blogs = $this->blogService->getPaginatedData(
            perPage: 12,
            filters: $this->getFilters(),
            page: $this->getPage()
        );
        $blogs->load('category');
        $categories = $this->blogCategoryService->getActiveCategories();

        return view('livewire.frontend.blog', [
            'blogs' => $blogs,
            'categories' => $categories,
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'from' => $blogs->firstItem(),
                'to' => $blogs->lastItem(),
                'total' => $blogs->total(),
            ],
        ]);
    }

    protected function getFilters(): array
    {
        $filters = [
            'status' => BlogStatus::PUBLISHED->value,
        ];
        $categorySlug = request()->query('category');
        if ($categorySlug) {
            $category = $this->blogCategoryService->findActiveBySlug($categorySlug);
            if ($category) {
                $filters['blog_category_id'] = $category->id;
            }
        }
        return $filters;
    }
}
