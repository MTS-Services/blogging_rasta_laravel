<?php

namespace App\Livewire\Backend\Admin;

use App\Livewire\Forms\Backend\Admin\AboutCmsForm;
use App\Services\AboutCmsService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use App\Models\AboutCms as AboutCmsModel;

class AboutCms extends Component
{
    use WithFileUploads, WithNotification;

    public AboutCmsForm $form;
    public ?AboutCmsModel $data;
    public $existingBannerVideo;

    protected AboutCmsService $service;

    public function boot(AboutCmsService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->data = $this->service->getFirstData();
        if ($this->data) {
            $this->form->setData($this->data);
            $this->existingBannerVideo = $this->data->banner_video;
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.about-cms');
    }

    public function update()
    {

        $validated = $this->form->validate();
        try {
            $this->data = $this->service->createOrUpdateData($validated);
            $this->success('Data updated successfully');
            return $this->redirect(route('admin.about-cms'), navigate: true);
        } catch (\Throwable $e) {
            Log::error('Failed to update about cms', [
                'about_cms_id' => $this->model->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Data update failed.');
        }
    }

    public function resetForm(): void
    {
        $this->form->reset();
        if ($this->data !== null) {
            $this->form->setData($this->data);
            $this->existingBannerVideo = $this->data->banner_video;
        }
    }
}
