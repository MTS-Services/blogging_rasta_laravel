<?php

namespace App\Livewire\Backend\Admin\Settings\Currency;

use App\Enums\CurrencyStatus;
use App\Services\CurrencyService;
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

    protected $listeners = ['CurrencyDeleted' => '$refresh', 'CurrencyRestored' => '$refresh', 'CurrencyUpdated' => '$refresh'];

    protected CurrencyService $service;

    public function boot(CurrencyService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getTrashedPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );
        $datas->load('deleter_admin');

        $columns = [

            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'code',
                'label' => 'Code',
                'sortable' => true
            ],
            [
                'key' => 'symbol',
                'label' => 'Symbol',
                'sortable' => true
            ],
            [
                'key' => 'exchange_rate',
                'label' => 'Exchange Rate',
                'sortable' => true,
                'format' => function ($data) {
                    return number_format($data->exchange_rate, $data->decimal_places);
                }
            ],
            [
                'key' => 'decimal_places',
                'label' => 'Decimal Places',
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
                'key' => 'deleted_at',
                'label' => 'Deleted Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->deleted_at_formatted;
                }
            ],
            [
                'key' => 'deleted_by',
                'label' => 'Deleted By',
                'format' => function ($data) {
                    return $data->deleter_admin?->name ?? 'System';
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
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'forceDelete', 'label' => 'Permanent Delete'],
        ];

        return view('livewire.backend.admin.settings.currency.trash', [
            'datas' => $datas,
            'statuses' => CurrencyStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        if (!$encryptedId) {
            $this->error('No Currency selected');
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
            $this->success('Currency permanently deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete currency.');
            Log::error('Failed to delete currency: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($encryptedId): void
    {
        try {
            $this->service->restoreData(decrypt($encryptedId));

            $this->success('Currency restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore currency.');
            Log::error('Failed to restore currency: ' . $e->getMessage());
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
            $this->warning('Please select currency and an action');
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
        $this->success("{$count} Currencies restored successfully");
    }

    protected function bulkForceDelete(): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkForceDeleteData($this->selectedIds);
        $this->success("{$count} Currencies permanently deleted successfully");
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
