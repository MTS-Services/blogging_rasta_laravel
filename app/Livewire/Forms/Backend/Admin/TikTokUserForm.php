<?php

namespace App\Livewire\Forms\Backend\Admin;

use App\Enums\TikTokUserStatus;
use Livewire\Form;
use App\Models\TikTokUser;
use Livewire\Attributes\Locked;

class TikTokUserForm extends Form
{

    #[Locked]
    public ?int $id = null;
    public int $sort_order = 0;
    public ?string $user_category_id = '';
    public ?string $name = '';
    public ?string $username = '';
    public ?int $max_videos = null;
    public string $status = TikTokUserStatus::ACTIVE->value;



    // ---------------------------
    // Validation Rules
    // ---------------------------
    public function rules(): array
    {
        $userName = $this->isUpdating()
            ? 'sometimes|required|string|max:255|unique:tik_tok_users,username,' . $this->id
            : 'required|string|max:255|unique:tik_tok_users,username';
        return [
            'name' => 'required|string|max:255',
            'user_category_id' => 'required|string|max:255',
            'username' => $userName,
            'max_videos' => 'required|integer',
            'status' => 'required|string|in:' . implode(',', array_column(TikTokUserStatus::cases(), 'value')),
        ];
    }


    /**
     * Fill the form fields from a Language model
     */
    public function setData(TikTokUser $data): void
    {
        $this->id = $data->id;
        $this->user_category_id = $data->user_category_id;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->max_videos = $data->max_videos;
        $this->status = $data->status->value;

    }

    /**
     * Reset form fields
     */
    public function reset(...$properties): void
    {
        $this->id = null;
        $this->sort_order = 0;
        $this->user_category_id = null;
        $this->name = '';
        $this->username = '';
        $this->max_videos = null;
        $this->status = TikTokUserStatus::ACTIVE->value;

        $this->resetValidation();
    }



    /**
     * Determine if the form is updating an existing record
     */
    protected function isUpdating(): bool
    {
        return !empty($this->id);
    }
}
