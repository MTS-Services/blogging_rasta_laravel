<?php

namespace App\Livewire\Backend\Admin\Blog;

use App\Enums\AdminStatus;
use App\Enums\BlogStatus;
use App\Services\BlogService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteDataId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;


    protected BlogService $service;

    public function boot(BlogService $service)
    {
      
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('creater_admin');
        $columns = [
            // [
            //     'key' => 'avatar',
            //     'label' => 'Avatar',
            //     'format' => function ($data) {
            //         return $data->avatar_url
            //             ? '<img src="' . $data->avatar_url . '" alt="' . $data->name . '" class="w-10 h-10 rounded-full object-cover shadow-sm">'
            //             : '<div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-semibold">' . strtoupper(substr($data->name, 0, 2)) . '</div>';
            //     }
            // ],
            [
                'key' => 'title',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'slug',
                'label' => 'Slug',
                'sortable' => true
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
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return optional($data->creater_admin)->name
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . e($data->creater_admin->name) . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                },
                'sortable' => true,
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.blog.view',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.blog.edit',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'published', 'label' => 'Published'],
            ['value' => 'unpublished', 'label' => 'Unpublished'],
        ];

        return view('livewire.backend.admin.blog.index', [
            'datas' => $datas,
            'statuses' => BlogStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        $this->deleteDataId = decrypt($encryptedId);
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteDataId) {
                return;
            }

            $this->service->deleteData($this->deleteDataId);

            $this->showDeleteModal = false;
            $this->deleteDataId = null;

            $this->success('Data deleted successfully');
        } catch (\Throwable $e) {
            Log::error('Failed to delete data', [
                'admin_id' => $this->deleteDataId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to delete data.');
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Datas and an action');
            Log::info('No datas selected or no bulk action selected');
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
                'published' => $this->bulkUpdateStatus(BlogStatus::PUBLISHED),
                'unpublished' => $this->bulkUpdateStatus(BlogStatus::UNPUBLISHED),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function bulkDelete(): void
    {
        $count = $this->service->bulkDeleteData($this->selectedIds, admin()->id);

        $this->success("{$count} Datas deleted successfully");
    }

    protected function bulkUpdateStatus(BlogStatus $status): void
    {
        $count = $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Datas updated successfully");
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

   protected function getSelectableIds(): array
    {
        $data = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return array_column($data->items(), 'id');
    }
    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
