<?php

namespace App\Livewire\Forms\Backend\Admin;

use Livewire\Form;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Http\UploadedFile;

class AboutCmsForm extends Form
{
    use WithFileUploads;















    #[Locked]
    public ?int $id = null;

    public string $contact_email = '';
    public ?UploadedFile $banner_video = null;
    public $removeBannerVideo = false;

    public string $title_en = '';
    public string $title_fr = '';
    public string $about_us_en = '';
    public string $about_us_fr = '';
    public string $mission_title_en = '';
    public string $mission_title_fr = '';
    public string $mission_en = '';
    public string $mission_fr = '';




    public function rules(): array
    {
        return [
            'banner_video' => 'nullable',
            'title_en' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'about_us_en' => 'required|string',
            'about_us_fr' => 'required|string',
            'mission_title_en' => 'required|string|max:255',
            'mission_title_fr' => 'required|string|max:255',
            'mission_en' => 'required|string',
            'mission_fr' => 'required|string',
            'contact_email' => 'required|email|max:255',


            'removeBannerVideo' => 'boolean',
        ];
    }



    public function setData($data): void
    {
        $this->id = $data->id;
        $this->title_en = $data->title_en;
        $this->title_fr = $data->title_fr;
        $this->about_us_en = $data->about_us_en;
        $this->about_us_fr = $data->about_us_fr;
        $this->mission_title_en = $data->mission_title_en;
        $this->mission_title_fr = $data->mission_title_fr;
        $this->mission_en = $data->mission_en;
        $this->mission_fr = $data->mission_fr;
        $this->contact_email = $data->contact_email;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->banner_video = null;
        $this->resetValidation();
    }
}
