<?php

namespace App\Livewire\Backend\Admin\Blog;

use App\Enums\AdminStatus;
use App\Enums\BlogStatus;
use App\Livewire\Forms\BlogForm;
use App\Models\Blog;
use App\Services\BlogCategoryService;
use App\Services\BlogService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public $metaKeywordInput;
    public BlogForm $form;
    public Blog $data;
    public $existingFile;
    public $existingFiles;

    protected BlogService $service;

    protected BlogCategoryService $blogCategoryService;

    public function boot(BlogService $service, BlogCategoryService $blogCategoryService)
    {
        $this->service = $service;
        $this->blogCategoryService = $blogCategoryService;
    }

    public function mount(Blog $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->file;
    }

    public function addMetaKeyword(): void
    {
        $value = trim($this->metaKeywordInput);

        if (empty($value)) {
            return;
        }

        if ($this->form->meta_keywords === null) {
            $this->form->meta_keywords = [];
        }

        $exists = collect($this->form->meta_keywords)
            ->map(fn($type) => strtolower($type))
            ->contains(strtolower($value));

        if ($exists) {
            $this->addError('metaKeywordInput', 'this meta keyword already exists');
            return;
        }

        $this->form->meta_keywords[] = $value;
        $this->metaKeywordInput = '';
        $this->resetErrorBag('metaKeywordInput');
    }

    /**
     * Remove a specific meta keyword
     */
    public function removeMetaKeyword(int $index): void
    {
        if (isset($this->form->meta_keywords[$index])) {
            unset($this->form->meta_keywords[$index]);
            $this->form->meta_keywords = array_values($this->form->meta_keywords);
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.blog.edit', [
            'statuses' => BlogStatus::options(),
            'categories' => $this->blogCategoryService->getActiveCategories(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['updated_by'] = admin()->id;
            $this->data = $this->service->updateData($this->data->id, $validated);

            $this->success('Data updated successfully');
            return $this->redirect(route('admin.blog.index'), navigate: true);
        } catch (\Throwable $e) {
            Log::error('Failed to update data', [
                'blog_id' => $this->data->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update data.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->data);
    }
}
