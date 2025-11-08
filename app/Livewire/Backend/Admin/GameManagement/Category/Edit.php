<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GameCategory;
use App\Enums\GameCategoryStatus;
use Illuminate\Support\Facades\Log;
use App\Services\GameCategoryService;
use App\Traits\Livewire\WithNotification;
use App\DTOs\GameCategory\UpdateGameCategoryDTO;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameCategoryForm;

class Edit extends Component
{
    use WithNotification, WithFileUploads;


    public GameCategoryForm $form;
    public GameCategory $category;
    protected GameCategoryService $service;
    public $categoryId = null;

    public function boot(GamecategoryService $service)
    {
        $this->service = $service;
    }
    public function mount(GameCategory $data)
    {
        $this->form->setCategory($data);
        $this->categoryId = $data->id;
    }
    public function render()
    {
        return view('livewire.backend.admin.game-management.category.edit', [
            'statuses'   => GameCategoryStatus::options(),
        ]);
    }


    public function update()
    {
        $this->form->validate();

        try {

            $data = $this->form->validate();
            $this->service->updateData($this->categoryId, $data, admin()->id);
            $this->success('Game Category Updated Successfully');
            return $this->redirect(route('admin.gm.category.index'), navigate: true);
        } catch (\Exception $e) {
            Log::error("Error", ['error' => $e->getMessage()]);
            $this->error('Failed to Upate Game Category');
        }
    }
}
