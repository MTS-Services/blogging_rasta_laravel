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
    public ?UploadedFile $banner_video = null;

    public $removeThumbnail = false;
    public $removeBannerVideo = false;

    public string $title_en = '';
    public string $description_en = '';
    public string $title_fr = '';
    public string $description_fr = '';


    public function rules(): array
    {
        return [
            'thumbnail' => 'nullable',
            'banner_video' => 'nullable',
            'title_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'title_fr' => 'required|string|max:255',
            'description_fr' => 'required|string',
            'removeThumbnail' => 'boolean',
            'removeBannerVideo' => 'boolean',
        ];
    }



    public function setData($data): void
    {
        $this->id = $data->id;
        $this->title_en = $data->title_en;
        $this->description_en = $data->description_en;
        $this->title_fr = $data->title_fr;
        $this->description_fr = $data->description_fr;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->thumbnail = null;
        $this->banner_video = null;
        $this->resetValidation();
    }
}
