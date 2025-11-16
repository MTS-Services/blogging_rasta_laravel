<?php

namespace App\Livewire\Backend\Admin\Blog;


use App\Enums\BlogStatus;
use App\Livewire\Forms\BlogForm;
use App\Services\BlogService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    public BlogForm $form;

    protected BlogService $service;

    public function boot(BlogService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.backend.admin.blog.create', [
            'statuses' => BlogStatus::options(),
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
