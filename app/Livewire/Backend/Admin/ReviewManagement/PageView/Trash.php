<?php

namespace App\Livewire\Backend\Admin\ReviewManagement\PageView;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Services\PageViewService;
use App\Traits\Livewire\WithNotification;

class Trash extends Component
{

    use WithDataTable, WithNotification;


    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $selectedId = null;



    protected PageViewService $service;

    public function boot(PageViewService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $datas = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [
            [
                'key' => 'viewable_type',
                'label' => 'Viewable Type',
                'sortable' => true
            ],
            [
                'key' => 'viewable_id',
                'label' => 'Viewable ID',
                'sortable' => true
            ],
            [
                'key' => 'viewer_type',
                'label' => 'Viewer Type',
                'sortable' => true
            ],
            [
                'key' => 'viewer_id',
                'label' => 'Viewer ID',
                'sortable' => true
            ],
            [
                'key' => 'ip_address',
                'label' => 'IP Address',
                'sortable' => true
            ],
            [
                'key' => 'user_agent',
                'label' => 'User Agent',
                'sortable' => true
            ],
            [
                'key' => 'referrer',
                'label' => 'Referrer',
                'sortable' => true
            ],

            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater_admin?->name ?? 'System';
                }
            ],

        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'Restore',
                'method' => 'restore',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Permanent Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];
        $bulkActions = [
            ['value' => 'forceDelete', 'label' => 'Permanent Delete'],
            ['value' => 'bulkRestore', 'label' => 'Restore Selected'],
        ];
        return view('livewire.backend.admin.review-management.page-view.trash', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }


    public function confirmDelete($encryptedId): void
    {
        if (!$encryptedId) {
            $this->error('No Page View selected');
            $this->resetPage();
            return;
        }
        $this->selectedId = $encryptedId;
        $this->showDeleteModal = true;
    }

    public function forceDelete(): void
    {
        try {
            $this->service->deleteData(decrypt($this->selectedId), forceDelete: true);
            $this->showDeleteModal = false;
            $this->selectedId = null;
            $this->resetPage();
            $this->success('Page View permanently deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete Page View.');
            Log::error('Failed to delete Page View: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($encryptedId): void
    {
        try {
            $this->service->restoreData(decrypt($encryptedId));

            $this->success('Page View restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore Page View.');
            Log::error('Failed to restore Page View: ' . $e->getMessage());
            throw $e;
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
            $this->warning('Please select Page View and an action');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'forceDelete' => $this->bulkForceDelete(),
                'bulkRestore' => $this->bulkRestore(),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Failed to execute bulk action.');
            Log::error('Failed to execute bulk action: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function bulkRestore(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkRestoreData($this->selectedIds);
        $this->success("{$count} Page Views restored successfully");
    }

    protected function bulkForceDelete(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} Page Views permanently deleted successfully");
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
        return $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
