<?php

namespace App\Livewire\Backend\Admin\AuditLogManagement;

use App\Services\AuditService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;


    protected AuditService $auditService;

    public function boot(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

    public function render()
    {
        $datas = $this->auditService->getPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $columns = [
            [
                'key' => 'id',
                'label' => 'ID',
                'sortable' => true
            ],
            [
                'key' => 'event',
                'label' => 'Event',
                'sortable' => true
            ],
            [
                'key' => 'auditable_type',
                'label' => 'Auditable',
                'sortable' => true
            ],
            [
                'key' => 'guard',
                'label' => 'Guard',
                'sortable' => true
            ],
            [
                'key' => 'ip_address',
                'label' => 'IP Address',
                'sortable' => true
            ],
            
            [
                'key' => 'created_at',
                'label' => 'Audit Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
            [
                'key' => 'user.name',
                'label' => 'Audit By',
                'sortable' => true,
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.alm.audit.view',
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete',
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
        ];

        return view('livewire.backend.admin.audit-log-management.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }
    
    public function delete(): void
    {
        // dd($this->deleteAdminId);
        try {
            if (!$this->deleteId) {
                return;
            }
            $this->auditService->deleteData($this->deleteId);

            $this->reset(['showDeleteModal', 'deleteId']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete data: ' . $e->getMessage());
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
            $this->warning('Please select datas and an action');
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
        $count = $this->auditService->bulkDeleteData($this->selectedIds);
        $this->success("{$count} datas deleted successfully");
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
        return collect($this->auditService->getPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        ))->pluck('id')->toArray();
    }
}
