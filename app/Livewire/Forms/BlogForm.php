<?php

namespace App\Livewire\Forms;

use App\Enums\BlogStatus;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class BlogForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public int $sort_order = 0;
    public ?string $title = '';
    public ?string $slug = '';
    public string $status = BlogStatus::UNPUBLISHED->value;

    public ?UploadedFile $file = null;
    public bool $remove_file = false;

    public string $description = '';

    public ?string $meta_title = '';
    public ?string $meta_description = '';
    public array $meta_keywords = [];

    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        return [
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:blogs,slug,' . $this->id,
            'status' => 'required|string|in:' . implode(',', array_column(BlogStatus::cases(), 'value')),

            'file'              => 'nullable|max:1024',
            'remove_file'      => 'boolean',

            'description'       => 'nullable|string',
            'meta_title'        => 'nullable|string',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|array',
        ];
    }

    // ---------------------------
    // Fill Form with Existing Data
    // ---------------------------
    public function setData($data): void
    {
        $this->id                = $data->id;
        $this->title             = $data->title;
        $this->slug              = $data->slug;
        $this->status            = $data->status->value;
        $this->description       = $data->description ?? '';

        $this->meta_title        = $data->meta_title ?? '';
        $this->meta_description  = $data->meta_description ?? '';
        $this->meta_keywords     = $data->meta_keywords ?? [];
    }

    // ---------------------------
    // Reset Form
    // ---------------------------
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->sort_order = 0;
        $this->title = '';
        $this->slug = '';
        $this->status = BlogStatus::UNPUBLISHED->value;
        $this->file = null;
        $this->description = '';

        $this->meta_title = '';
        $this->meta_description = '';
        $this->meta_keywords = [];

        $this->resetValidation();
    }



    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
