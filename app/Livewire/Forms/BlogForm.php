<?php

namespace App\Livewire\Forms;

use App\Enums\BlogStatus;
use App\Livewire\Frontend\Blog;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Form;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;

class BlogForm extends Form
{
    use WithFileUploads;

    #[Locked]
    public ?int $id = null;

    public int $sort_order = 0;
    public string $title = '';
    public string $slug = '';
    public string $status = BlogStatus::UNPUBLISHED->value;

    public ?UploadedFile $file = null;

    public string $description = '';

    public ?string $meta_title = '';
    public ?string $meta_description = '';
    public array $meta_keywords = [];

    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        $slug = Str::slug((string) $this->slug);
        return [
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:blogs,slug,' . $this->id,
            'status' => 'required|string|in:' . implode(',', array_column(BlogStatus::cases(), 'value')),

            'file'              => $this->isUpdating()
                ? 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240'
                : 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',

            'description'       => 'nullable|string',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'meta_keywords'     => 'nullable|array',
        ];
    }

    // ---------------------------
    // Fill Form with Existing Data
    // ---------------------------
    public function setData($blog): void
    {
        $this->id                = $blog->id;
        $this->sort_order        = $blog->sort_order;
        $this->title             = $blog->title;
        $this->slug              = $blog->slug;
        $this->status            = $blog->status;
        $this->description       = $blog->description ?? '';

        $this->meta_title        = $blog->meta_title ?? '';
        $this->meta_description  = $blog->meta_description ?? '';
        $this->meta_keywords     = $blog->meta_keywords ?? [];

        $this->file = null; // reset file upload
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
