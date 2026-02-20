<?php

namespace App\Livewire\Backend\Admin\Blog;


use App\Enums\BlogStatus;
use App\Livewire\Forms\BlogForm;
use App\Services\BlogCategoryService;
use App\Services\BlogService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public BlogForm $form;

    public string $metaKeywordInput = '';

    protected BlogService $service;

    protected BlogCategoryService $blogCategoryService;

    public function boot(BlogService $service, BlogCategoryService $blogCategoryService)
    {
        $this->service = $service;
        $this->blogCategoryService = $blogCategoryService;
    }


    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->meta_keywords = [];
    }

    /**
     * Add a product type when Enter is pressed
     */
    public function addMetaKeyword(): void
    {
        $value = trim($this->metaKeywordInput);
        
        // Check if input is not empty
        if (empty($value)) {
            return;
        }

        // Initialize array if null
        if ($this->form->meta_keywords === null) {
            $this->form->meta_keywords = [];
        }

        // Check if already exists (case-insensitive)
        $exists = collect($this->form->meta_keywords)
            ->map(fn($keyword) => strtolower($keyword))
            ->contains(strtolower($value));

        if ($exists) {
            $this->addError('metaKeywordInput', 'this meta keyword already exists');
            return;
        }

        // Add to array
        $this->form->meta_keywords[] = $value;
        
        // Clear input
        $this->metaKeywordInput = '';
        $this->resetErrorBag('metaKeywordInput');
    }

    /**
     * Remove a specific product type
     */
    public function removeMetaKeyword(int $index): void
    {
        if (isset($this->form->meta_keywords[$index])) {
            unset($this->form->meta_keywords[$index]);
            // Re-index array
            $this->form->meta_keywords = array_values($this->form->meta_keywords);
        }
    }




    public function render()
    {
        return view('livewire.backend.admin.blog.create', [
            'statuses' => BlogStatus::options(),
            'categories' => $this->blogCategoryService->getActiveCategories(),
        ]);
    }
    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['created_by'] = admin()->id;
            $this->service->createData($validated);

            $this->success('Data created successfully');
            return $this->redirect(route('admin.blog.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error('Failed to create data: ' . $e->getMessage());

            $this->error('Failed to create data.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
}
