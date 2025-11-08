<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use App\Enums\GameStatus;
use App\Services\GameService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $selectedId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    public $deleteId = null;

    protected GameService $service;

    public function boot(GameService $service)
    {
        $this->service = $service;
    }
    public function render()
    {

        $games = $this->service->getTrashedPaginateDatas($this->perPage, $this->filters());


        $columns = [
            // [
            //     'key' => 'id',
            //     'label' => 'ID',
            //     'sortable' => true
            // ],
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'slug',
                'label' => 'Slug',
                'sortable' => true
            ],
            // [
            //     'key' => 'status',
            //     'label' => 'Status',
            //     'sortable' => true,
            //     'format' => function ($admin) {
            //         $colors = [
            //             'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            //             'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            //             'suspended' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            //         ];
            //         $color = $colors[$admin->status->value] ?? 'bg-gray-100 text-gray-800';
            //         return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' .
            //             ucfirst($admin->status->value) .
            //             '</span>';
            //     }
            // ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($arg) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $arg->created_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $arg->created_at->format('h:i A') . '</div>' .
                        '</div>';
                }
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($arg) {
                    return $arg->creater_admin
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $arg->creater_admin->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'Restore', 'method' => 'restore', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete', 'encrypt' => true],
        ];

        $bulkActions = [
            ['value' => 'restore', 'label' => 'Restore'],
            ['value' => 'delete', 'label' => 'Delete'],
        ];



        return view(
            'livewire.backend.admin.game-management.game.trash',
            [
                'games' => $games,
                'columns' => $columns,
                'actions' => $actions,
                'bulkActions' => $bulkActions,
                'bulkAction'  => $this->bulkAction,
                'statuses' =>  GameStatus::options()
            ]
        );
    }


    public function filters()
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    public function restore($encrypted_id)
    {

        try {
            $this->service->restoreData(decrypt($encrypted_id), admin()->id);

            $this->success('Data restored successfully');
        } catch (\Exception $e) {

            $this->error('Failed to restore data.');

            Log::error('Failed to restore data: ' . $e->getMessage());
        }
    }

    public function confirmDelete($encrypted_id)
    {
        $this->showDeleteModal = true;
        $this->deleteId = $encrypted_id;
    }

    public function delete()
    {

        try {
            if (!$this->deleteId) {
                $this->warning('No data selected');
                return;
            }
            $this->service->forceDeleteData(decrypt($this->deleteId), true);
            $this->reset(['deleteId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {

            Log::error("Failed to delete data", ['error' => $e->getMessage()]);

            $this->error('Failed to delete data.');
        }
    }
    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Games and an action');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkForceDelete(),
                'restore' => $this->bulkRestore(),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    public function bulkForceDelete(): void
    {

        try {
            $count = $this->service->bulkForceDelete($this->selectedIds);

            $this->success("{$count} Datas deleted successfully");
        } catch (\Exception $e) {

            Log::error("Failed to delete data", ['error' => $e->getMessage()]);

            $this->error('Failed to delete data.');
        }
    }

    public function bulkRestore(): void
    {
        try {
            if (! count($this->selectedIds)) {
                $this->warning('No data selected');
                return;
            }
            $count =  $this->service->bulkRestore($this->selectedIds, admin()->id);

            $this->success("{$count} Data restored successfully");
        } catch (\Exception $e) {

            Log::error("Failed to delete data", ['error' => $e->getMessage()]);

            $this->error('Failed to delete data.');
        }
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getTrashedPaginateDatas(
            perPage: $this->perPage,
            filters: $this->filters()
        )->pluck('id')->toArray();
    }
}
