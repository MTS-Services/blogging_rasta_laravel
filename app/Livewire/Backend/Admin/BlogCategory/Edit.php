<?php

namespace App\Livewire\Backend\Admin\BlogCategory;

use App\Livewire\Forms\BlogCategoryForm;
use App\Models\BlogCategory;
use App\Services\BlogCategoryService;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;
use App\Traits\Livewire\WithNotification;

class Edit extends Component
{
    use WithNotification;

    public BlogCategoryForm $form;

    #[Locked]
    public BlogCategory $data;

    protected BlogCategoryService $service;

    public function boot(BlogCategoryService $service): void
    {
        $this->service = $service;
    }

    public function mount(BlogCategory $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
    }

    public function updatedFormTitle($value): void
    {
        $this->form->slug = Str::slug($value);
    }

    public function render()
    {
        return view('livewire.backend.admin.blog-category.edit');
    }

    public function save()
    {
        $data = $this->form->validate();
        try {
            $data['updated_by'] = admin()->id;
            $this->service->updateData($this->data->id, $data);
            $this->success(__('Data updated successfully.'));
            return $this->redirect(route('admin.blog-category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to update data: ' . $e->getMessage());
        }
    }

    public function resetForm(): void
    {
        $this->form->setData($this->data);
        $this->form->resetValidation();
    }
}
