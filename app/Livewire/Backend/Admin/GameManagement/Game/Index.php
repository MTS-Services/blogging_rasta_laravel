<?php

namespace App\Livewire\Backend\Admin\GameManagement\Game;

use Livewire\Component;

use App\Services\GameService;

use App\Traits\Livewire\WithDataTable;

use App\Enums\GameStatus;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;

class Index extends Component
{

    use withDataTable, WithNotification;


    protected GameService $service;
    public string $bulkAction = '';
    public $statusFilter = '';
    public $showBulkActionModal = false;
    public $showDeleteModal = false;
    public $deleteId = null;


    public function boot(GameService $service)
    {
        $this->service = $service;
    }
    public function render()
    {

        $datas = $this->service->getPaginateDatas($this->perPage, $this->filters());


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
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
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
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.gm.game.view', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.gm.game.edit', 'ecrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete', 'encrypt' => true],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'inactivate', 'label' => 'Inactive'],
        ];



        return view(
            'livewire.backend.admin.game-management.game.index',
            [
                'datas' => $datas,
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
            $this->service->deleteData(decrypt($this->deleteId));

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
            $this->warning('Please select categories and an action');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkDelete(),
                'activate' => $this->bulkUpdateStatus(GameStatus::ACTIVE),
                'inactivate' => $this->bulkUpdateStatus(GameStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            dd('Bulk action failed: ' . $e->getMessage());
        }
    }

    public function bulkDelete(): void
    {
        try {

            $count =    $this->service->bulkDelete($this->selectedIds,  admin()->id);

            $this->success("($count) Datas deleted successfully");
        } catch (\Exception $e) {

            $this->error('Failed to delete data.');

            log::error('Failed to delete data: ' . $e->getMessage());
        }
    }

    public function bulkUpdateStatus(GameStatus $status): void
    {

        try {

            $count =  $this->service->bulkUpdateStatus($this->selectedIds, $status, admin()->id);

            $this->success("($count)  Status change successfully");
        } catch (\Exception $e) {

            $this->error('Failed to change status.');
        }
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getPaginateDatas(
            perPage: $this->perPage,
            filters: $this->filters()
        )->pluck('id')->toArray();
    }
}
