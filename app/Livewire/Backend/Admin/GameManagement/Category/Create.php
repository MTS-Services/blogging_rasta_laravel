<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Enums\GameCategoryStatus;
use Illuminate\Support\Facades\Log;
use App\Services\GameCategoryService;
use App\DTOs\Game\CreateGameCategoryDTO;
use App\Traits\Livewire\WithNotification;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameCategoryForm;

class Create extends Component
{
    use WithNotification, WithFileUploads;
    protected GameCategoryService $service;
    public GameCategoryForm $form;

    public function boot(GameCategoryService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->form->status = GameCategoryStatus::ACTIVE->value;
    }
    public function render()
    {

        return view('livewire.backend.admin.game-management.category.create', [
            'statuses'   => GameCategoryStatus::options(),
        ]);
    }


    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {

        try {
            $data = $this->form->validate();
            $data['created_by'] = admin()->id;
            $data['icon'] = $this->form->icon;
            $this->service->createData($data);
            $this->success('Data created successfully.');

            return $this->redirect(route('admin.gm.category.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create data: ' . $e->getMessage());
        }
    }
    public function resetFrom()
    {
        $this->form->reset();
    }
}
