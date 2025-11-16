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
    public BannerVideo $data;
    public $existingFile;

    protected BannerVideoService $service;

    public function boot(BannerVideoService $service)
    {
        $this->service = $service;
    }

    public function mount(BannerVideo $data): void
    {
        $this->data = $data;
        $this->form->setData($data);
        $this->existingFile = $data->thumbnail;
    }

    public function render()
    {
        return view('livewire.backend.admin.banner-video.edit');
    }

    public function update()
    {
        $validated = $this->form->validate();

        try {


            $validated['updated_by'] = admin()->id;

            $this->data = $this->service->createOrUpdateData($validated);


            $this->form->setData($this->model);

            $this->form->reset(['thumbnail', 'file']);

            $this->dispatch('BannerVideoUpdated');
            $this->success('Data updated successfully');
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
        $this->form->setData($this->model);
    }

    public function removeThumbnail(): void
    {
        $this->form->reset('thumbnail');
    }

    public function removeFile(): void
    {
        $this->form->reset('file');
    }
}
