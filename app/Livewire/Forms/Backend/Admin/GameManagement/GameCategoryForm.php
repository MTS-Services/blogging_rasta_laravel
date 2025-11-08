<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use Livewire\Attributes\Locked;
use Livewire\Form;

class GameCategoryForm extends Form
{

    #[Locked]
    public ?int $id;

    public string $name;
    public string $slug;
    public ?string $description;
    public string $status;
    public ?string $meta_title;
    public ?string $meta_description;
    public bool $is_featured = false;

    public $icon = null;





    public function rules(): array
    {
        $slugRule = $this->isUpdating()
            ? 'required|string|max:255|unique:game_categories,slug,' . $this->id
            : 'required|string|max:255|unique:game_categories,slug';

        return [
            'name' => 'required|string|max:255',
            'slug' => $slugRule,
            'description' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_column(GameCategoryStatus::cases(), 'value')),
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'icon' => 'nullable|image|max:1024|dimensions:max_width=200,max_height=200',
            'is_featured' => 'nullable|boolean',
        ];
    }

    public function setCategory(GameCategory $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->slug = $data->slug;
        $this->description = $data->description;
        $this->status = $data->status->value;
        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        // $this->icon = $data->icon;
        $this->is_featured = $data->is_featured;
    }

    public function reset(...$properties): void
    {
        $this->id = null;
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->status = GameCategoryStatus::ACTIVE->value;
        $this->meta_title = '';
        $this->meta_description = '';
        $this->icon = null;
        $this->is_featured = false;
        $this->resetValidation();
    }

    // public function fillables(): array
    // {
    //     return [
    //         'name' => $this->name,
    //         'slug' => $this->slug,
    //         'description' => $this->description,
    //         'status' => $this->status,
    //         'meta_title' => $this->meta_title,
    //         'meta_description' => $this->meta_description,
    //         'icon' => $this->icon,
    //         'is_featured' => $this->is_featured,

    //     ];
    // }

    public function isUpdating(): bool
    {
        return isset($this->id);
    }
}
