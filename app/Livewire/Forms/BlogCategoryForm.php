<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;

class BlogCategoryForm extends Form
{
    #[Locked]
    public ?int $id = null;

    public int $sort_order = 0;
    public string $title = '';
    public string $slug = '';
    public string $status = 'active';

    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'required|string|max:255|unique:blog_categories,slug,' . $this->id
            : 'required|string|max:255|unique:blog_categories,slug';

        return [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'status' => 'required|string|in:active,inactive',
        ];
    }

    public function setData($data): void
    {
        $this->id = $data->id;
        $this->title = $data->title;
        $this->slug = $data->slug;
        $this->status = $data->status ?? 'active';
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->sort_order = 0;
        $this->title = '';
        $this->slug = '';
        $this->status = 'active';
        $this->resetValidation();
    }

    protected function isUpdating(): bool
    {
        return ! empty($this->id);
    }
}
