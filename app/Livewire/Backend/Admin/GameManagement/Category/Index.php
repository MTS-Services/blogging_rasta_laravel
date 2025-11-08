<?php

namespace App\Livewire\Backend\Admin\GameManagement\Category;

use App\Enums\GameCategoryStatus;
use App\Services\GameCategoryService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Index extends Component
{

    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteGameCategoryId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $deleteId = null;


    // protected $listeners = ['adminCreated' => '$refresh', 'adminUpdated' => '$refresh'];

    protected GameCategoryService $service;

    public function boot(GameCategoryService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $datas->load('creater_admin');

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
                'format' => function ($category) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $category->created_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $category->created_at->format('h:i A') . '</div>' .
                        '</div>';
                }
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($category) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $category->status->color() . '">' .
                        $category->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($category) {
                    return $category->creater_admin
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $category->creater_admin?->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.gm.category.view', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.gm.category.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'inactivate', 'label' => 'Inactive'],
        ];


        return view('livewire.backend.admin.game-management.category.index', [
            'categories' => $datas,
            'statuses' => [],
            'columns' =>  $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    // public function confirmDelete($id)
    // {
    //     $this->showDeleteModal = true;
    //     $this->deleteGameCategoryId = $id;
    // }


    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteId) {
                $this->warning('No data selected');
                return;
            }
            $this->service->deleteData($this->deleteId);
            $this->reset(['deleteId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete data: ' . $e->getMessage());
        }
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteGameCategoryId = null;
    }
    // public function delete()
    // {

    //     try {


    //         if (!$this->deleteGameCategoryId) {
    //             return;
    //         }

    //         $state =   $this->service->deleteData($this->deleteGameCategoryId, admin()->id);

    //         if ($state) {
    //             $this->success('Category deleted successfully');
    //         }

    //         $this->showDeleteModal = false;
    //         $this->deleteGameCategoryId = null;
    //     } catch (\Exception $e) {
    //         $this->error('Failed to delete category: ' . $e->getMessage());
    //     }
    // }

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
                'activate' => $this->bulkUpdateStatus(GameCategoryStatus::ACTIVE),
                'inactivate' => $this->bulkUpdateStatus(GameCategoryStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    public function bulkDelete(): void
    {


        $count = $this->service->bulkDeleteData($this->selectedIds, admin()->id);

        $this->success("{$count} categories deleted successfully");
    }

    public function bulkUpdateStatus(GameCategoryStatus $status): void
    {
        $count = $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} categories updated successfully");
    }

    protected function getSelectableIds(): array
    {
        return $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }
}
