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

    public $removeThumbnail = false;
    public $removeFile = false;


    public function rules(): array
    {
        return [
            'thumbnail' => 'nullable|image|max:2048',
            'file' => 'nullable',
            'removeThumbnail' => 'boolean',
            'removeFile' => 'boolean',
        ];
    }



    public function setData($data): void
    {
        $this->id = $data->id;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->thumbnail = null;
        $this->file = null;
        $this->resetValidation();
    }
}
