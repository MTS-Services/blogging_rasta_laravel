<?php

namespace App\Livewire\Backend\Admin\BlogCategory;

use App\Services\BlogCategoryService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $showDeleteModal = false;
    public $selectedId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected BlogCategoryService $service;

    public function boot(BlogCategoryService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('deleter_admin');

        $columns = [
            [
                'key' => 'title',
                'label' => __('Title'),
                'sortable' => true,
            ],
            [
                'key' => 'slug',
                'label' => __('Slug'),
                'sortable' => true,
            ],
            [
                'key' => 'deleted_at',
                'label' => __('Deleted Date'),
                'sortable' => true,
                'format' => function ($data) {
                    return $data->deleted_at_formatted;
                },
            ],
            [
                'key' => 'deleted_by',
                'label' => __('Deleted By'),
                'format' => function ($data) {
                    return $data->deleter_admin?->name ?? 'System';
                },
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => __('Restore'),
                'method' => 'restore',
                'encrypt' => true,
            ],
            [
                'key' => 'id',
                'label' => __('Permanent Delete'),
                'method' => 'confirmDelete',
                'encrypt' => true,
            ],
        ];

        $bulkActions = [
            ['value' => 'bulkRestore', 'label' => __('Restore')],
            ['value' => 'forceDelete', 'label' => __('Permanent Delete')],
        ];

        return view('livewire.backend.admin.blog-category.trash', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        if (! $encryptedId) {
            $this->error(__('No Data selected'));
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
            $this->success(__('Data permanently deleted successfully'));
        } catch (\Throwable $e) {
            $this->error(__('Failed to delete data.'));
            Log::error('Failed to delete data: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($encryptedId): void
    {
        try {
            $this->service->restoreData(decrypt($encryptedId));
            $this->success(__('Data restored successfully'));
        } catch (\Throwable $e) {
            $this->error(__('Failed to restore data.'));
            Log::error('Failed to restore data: ' . $e->getMessage());
            throw $e;
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning(__('Please select data and an action'));
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
            $this->error(__('Failed to execute bulk action.'));
            Log::error('Failed to execute bulk action: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function bulkRestore(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkRestoreData($this->selectedIds);
        $this->success("{$count} " . __('Datas restored successfully'));
    }

    protected function bulkForceDelete(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} " . __('Datas permanently deleted successfully'));
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    protected function getSelectableIds(): array
    {
        $data = $this->service->getTrashedPaginatedData(
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
