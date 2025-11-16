<?php

namespace App\Livewire\Backend\Admin\Blog;

use App\Enums\AdminStatus;
use App\Enums\BlogStatus;
use App\Livewire\Forms\BlogForm;
use App\Models\Blog;
use App\Services\BlogService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public BlogForm $form;
    public Blog $model;

    protected BlogService $service;

    public function boot(BlogService $service)
    {
        $this->service = $service;
    }

    public function mount(Blog $model): void
    {
        $this->model = $model;
        $this->form->setData($model);
    }

    public function render()
    {
        return view('livewire.backend.admin.blog.edit', [
            'statuses' => BlogStatus::options(),
        ]);
    }

    public function save()
    {
        $validated = $this->form->validate();
        try {
            $validated['updated_by'] = admin()->id;
            $this->model = $this->service->updateData($this->model->id, $validated);

            $this->success('Data updated successfully');
            return $this->redirect(route('admin.um.admin.index'), navigate: true);
        } catch (\Throwable $e) {
            Log::error('Failed to update Admin', [
                'admin_id' => $this->model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update data.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        $this->form->setData($this->model);
    }
}
