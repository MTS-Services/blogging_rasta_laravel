<?php

namespace App\Livewire\Backend\Admin\Contact;

use App\Services\ContactService;
use Livewire\Component;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteDataId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $data;


    protected ContactService $service;

    public function boot(ContactService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load(['deleter_admin']);

        $columns = [
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'email',
                'label' => 'Email',
                'sortable' => true
            ],
            [
                'key' => 'deleted_at',
                'label' => 'Deleted At',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->deleted_at_formatted;
                }
            ],
            [
                'key' => 'deleted_by',
                'label' => 'Deleted By',
                'format' => function ($data) {
                    return optional($data->deleter_admin)->name
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . e($data->deleter_admin->name) . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
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
                'label' => 'Permanently Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'bulkForceDelete', 'label' => 'Permanently Delete'],
        ];

        return view('livewire.backend.admin.contact.trash', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        $this->deleteDataId = decrypt($encryptedId);
        $this->showDeleteModal = true;
    }
    public function forceDelete(): void
    {
        try {
            $this->service->forceDeleteData($this->deleteDataId);
            $this->showDeleteModal = false;
            $this->resetPage();

            $this->success('Data deleted successfully');
        } catch (\Throwable $e) {
            Log::error('Failed to delete data: ' . $e->getMessage());
            $this->error('Failed to delete data.');
        }
    }
    public function restore($encryptedId): void
    {
        try {
            $this->service->restoreData(decrypt($encryptedId), admin()->id);
            $this->success('Data restored successfully');
        } catch (\Throwable $e) {
            Log::error('Failed to restore data: ' . $e->getMessage());
            $this->error('Failed to restore data.');
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
            Log::info('No Datas selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'bulkForceDelete' => $this->bulkForceDeleteDatas(),
                'bulkRestore' => $this->bulkRestoreDatas(),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Throwable $e) {
            Log::error('Bulk action failed: ' . $e->getMessage());
            $this->error('Bulk action failed.');
        }
    }

    protected function bulkRestoreDatas(): void
    {
        $count = $this->service->bulkRestoreData($this->selectedIds, admin()->id);
        $this->success("{$count} Datas restored successfully");
    }
    protected function bulkForceDeleteDatas(): void
    {
        $count = $this->service->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} Datas permanently deleted successfully");
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
        $data = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return array_column($data->items(), 'id');
    }
}
