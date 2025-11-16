<?php

namespace App\Livewire\Backend\Admin\BannerVideo;

use Livewire\Component;
use App\models\BannerVideo;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use App\Services\BannerVideoService;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\BannerVideo\BannerVideoForm;

class Edit extends Component
{
    use WithFileUploads, WithNotification;

    public BannerVideoForm $form;
    public ?BannerVideo $data;
    public $existingFile;
    public $existingThumbnail;

    protected BannerVideoService $service;

    public function boot(BannerVideoService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->data = $this->service->getFirstData();
        if ($this->data) {
            $this->form->setData($this->data);
            $this->existingFile = $this->data->file;
            $this->existingThumbnail = $this->data->thumbnail;
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.banner-video.edit');
    }

    public function update()
    {
        $validated = $this->form->validate();
        try {
            $this->data = $this->service->createOrUpdateData($validated);
            $this->success('Data updated successfully');
            return $this->redirect(route('admin.banner-video'), navigate: true);
        } catch (\Throwable $e) {
            Log::error('Failed to update BannerVideo', [
                'banner_video_id' => $this->model->id ?? null,
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
            $this->existingFile = $this->data->file;
            $this->existingThumbnail = $this->data->thumbnail;
        }
    }
}
