<?php

namespace App\Livewire\Forms\Backend\Admin\GameManagement;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GameForm extends Form
{
    // 

    #[Locked]

    public ?int $id = null;

    public ?string $name;

    public ?int $game_category_id;

    public ?string $status;

    public ?string $developer;

    public ?string $slug;

    public ?string $publisher;

    public  ?UploadedFile $logo = null;

    public ?UploadedFile $banner = null;

    public ?UploadedFile $thumbnail = null;

    public ?string $release_date;

    public ?array $platform = [];

    public ?string $description;

    public ?bool $is_featured;

    public ?bool $is_trending;

    public ?string $meta_title;

    public ?string $meta_description;

    public ?string $meta_keywords;

    public function rules() :array 
    {
        return [
            'name' => 'required|string|max:255',
            'game_category_id' => 'nullable|integer',
            'status' => 'required|string|in:'.implode(',', array_column(GameStatus::cases(), 'value')),
            'developer' => 'nullable|string',
            'publisher' => 'nullable|string',
            'logo' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'banner' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'release_date' => 'nullable|date|after_or_equal:today',
            'platform' => 'nullable|array',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|file|image|max:10240|mimes:jpg,jpeg,png',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ];
    }

    public function setData(Game $data) :void 
    {
        $this->id = $data->id;
        $this->game_category_id = $data->game_category_id;
        $this->name = $data->name;
        $this->status = $data->status->value;
        $this->developer = $data->developer;
        $this->publisher = $data->publisher;


        $this->release_date = $data->release_date;
        $this->platform = $data->platform;
        $this->description = $data->description;

        $this->is_featured = $data->is_featured;
        $this->is_trending = $data->is_trending;
        $this->meta_title = $data->meta_title;
        $this->meta_description = $data->meta_description;
        $this->meta_keywords = $data->meta_keywords;
        
    }

    public function reset(...$properties):void {
        $this->name = null;
        $this->game_category_id = null;
        $this->status = null;
        $this->developer = null;
        $this->publisher = null;
        $this->logo = null;
        $this->banner = null;
        $this->release_date = null;
        $this->platform = [];
        $this->description = null;
        $this->thumbnail = null;
        $this->is_featured = null;
        $this->is_trending = null;
        $this->meta_title = null;
        $this->meta_description = null;
        $this->meta_keywords = null;

        $this->resetValidation();
    }

    public function fillables():array {
        return [
            'name' => $this->name,
            'game_category_id' => $this->game_category_id,
            'status' => $this->status,
            'developer' => $this->developer,
            'publisher' => $this->publisher,
            'logo' => $this->logo,
            'banner' => $this->banner,
            'release_date' => $this->release_date,
            'platform' => $this->platform,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'is_featured' => $this->is_featured,
            'is_trending' => $this->is_trending,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords
        ];
    }

    public function isUpdating():bool {
        return isset($this->id);
    }   
}
