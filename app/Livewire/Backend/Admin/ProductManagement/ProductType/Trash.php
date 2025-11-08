<?php

namespace App\Livewire\Backend\Admin\ProductManagement\ProductType;

use Livewire\Component;
use App\Enums\ProductTypeStatus;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use App\Services\ProductTypeService;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $selectedId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected $listeners = ['ProductTypeDeleted' => '$refresh', 'ProductTypeRestored' => '$refresh', 'ProductTypeUpdated' => '$refresh'];

    protected ProductTypeService $service;

    public function boot(ProductTypeService $service)
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
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'description',
                'label' => 'Description',
                'sortable' => true
            ],
            [
                'key' => 'comission_rate',
                'label' => 'Comission Rate',
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
        return view('livewire.backend.admin.product-management.product-type.trash', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => ProductTypeStatus::options(),
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        if (!$encryptedId) {
            $this->error('No Product Type selected');
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
            $this->success('Product Type permanently deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete Product Type.');
            Log::error('Failed to delete Product Type: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($encryptedId): void
    {
        try {
            $this->service->restoreData(decrypt($encryptedId));

            $this->success('Product Type restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore Product Type.');
            Log::error('Failed to restore Product Type: ' . $e->getMessage());
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
            $this->warning('Please select Product Type and an action');
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
        $this->success("{$count} Product Types restored successfully");
    }

    protected function bulkForceDelete(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} Product Types permanently deleted successfully");
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
