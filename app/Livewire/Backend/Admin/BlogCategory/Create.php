<?php

namespace App\Livewire\Backend\Admin\BlogCategory;

use App\Livewire\Forms\BlogCategoryForm;
use App\Services\BlogCategoryService;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Traits\Livewire\WithNotification;

class Create extends Component
{
    use WithNotification;

    public BlogCategoryForm $form;

    protected BlogCategoryService $service;

    public function boot(BlogCategoryService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        //
    }

    public function updatedFormTitle($value): void
    {
        if (! $this->form->id) {
            $this->form->slug = Str::slug($value);
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.blog-category.create');
    }

    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['created_by'] = admin()->id;
            $data['updated_by'] = admin()->id;
            $this->service->createData($data);
            $this->success(__('Data created successfully.'));
            return $this->redirect(route('admin.blog-category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
    }
}
