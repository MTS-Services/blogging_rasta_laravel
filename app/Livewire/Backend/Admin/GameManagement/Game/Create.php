<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;



use App\Enums\GameStatus;
use App\Livewire\Forms\Backend\Admin\GameManagement\GameForm;
use App\Services\GameCategoryService;
use App\Services\GameService;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, WithNotification;

    protected GameService $service;

    public GameForm $form;

    protected GameCategoryService $categoryService;


    public function boot(GameService $service,  GameCategoryService $categoryService)
    {
        $this->service = $service;

        $this->categoryService = $categoryService;
    }
    public function render()
    {
        $platforms = [
            [
                'id' => 1,
                'name' => 'PC'
            ],
            [
                'id' => 2,
                'name' => 'Playstation'
            ],
            [
                'id' => 3,
                'name' => 'Xbox'
            ],
            [
                'id' => 4,
                'name' => 'Nintendo'
            ],

        ];

        return view('livewire.backend.admin.game-management.game.create', [

            'statuses'   => GameStatus::options(),

            'categories' => $this->gameCategory(),

            'platforms' => $platforms

        ]);
    }

    protected function gameCategory(): array
    {
        return $this->categoryService->getAllDatas()->pluck('name', 'id')->toArray();
    }

    public function save()
    {

        $this->form->validate();


        try {

            $data = $this->form->fillables();

            $this->service->createData($data);

            $this->success('Game created successfully.');

            return $this->redirect(route('admin.gm.game.index'), navigate: true);
        } catch (\Throwable $th) {

            Log::error("Failed to create game: ", ['error' => $th->getMessage()]);
            $this->error('Failed to create game.');
        }
    }

    public function resetForm()
    {
        $this->form->reset();
    }
}
