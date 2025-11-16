<?php

namespace App\Livewire\Forms\Backend\Admin\BannerVideo;

use Livewire\Form;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Http\UploadedFile;

class BannerVideoForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public ?UploadedFile $thumbnail = null;
    public ?UploadedFile $file = null;

    // public ?UploadedFile $avatar = null;


    public function rules(): array
    {


        return [
            'thumbnail' => 'nullable|image|max:2048',
            'file' => 'nullable|image|max:2048',
        ];
    }



    public function setData($data): void
    {
        $this->id = $data->id;
        $this->thumbnail = null;
        $this->file = null;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->thumbnail = null;
        $this->file = null;
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
