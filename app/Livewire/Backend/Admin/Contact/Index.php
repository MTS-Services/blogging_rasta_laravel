<?php

namespace App\Livewire\Backend\Admin\Contact;

use App\Models\Admin;
use App\Services\ContactService;
use Livewire\Component;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;


    protected ContactService $service;

    public function boot(ContactService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        $datas->load(['creater']);

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
                'key' => 'created_at',
                'label' => 'Sent At',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ]
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
        ];

        return view('livewire.backend.admin.contact.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($encryptedId): void
    {
        $this->deleteId = decrypt($encryptedId);
        $this->showDeleteModal = true;
    }

  public function delete(): void
    {
        try {
            if (!$this->deleteId) {
                return;
            }

            $this->service->deleteData($this->deleteId);

            $this->showDeleteModal = false;
            $this->deleteId = null;

            $this->success('Data deleted successfully');
        } catch (\Throwable $e) {
            Log::error('Failed to delete data', [
                'admin_id' => $this->deleteId,
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
            Log::info('No Datas selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    // public function executeBulkAction(): void
    // {
    //     $this->showBulkActionModal = false;

    //     try {
    //         match ($this->bulkAction) {
    //             'delete' => $this->bulkDelete(),
    //             'activate' => $this->bulkUpdateStatus(UserStatus::ACTIVE),
    //             'inactive' => $this->bulkUpdateStatus(UserStatus::INACTIVE),
    //             default => null,
    //         };

    //         $this->selectedIds = [];
    //         $this->selectAll = false;
    //         $this->bulkAction = '';
    //     } catch (\Exception $e) {
    //         $this->error('Bulk action failed: ' . $e->getMessage());
    //     }
    // }

    protected function bulkDelete(): void
    {
        $count = $this->service->bulkDeleteData(ids: $this->selectedIds, actioner: [
            'id' => admin()->id,
            'type' => Admin::class,
        ]);

        $this->success("{$count} Datas deleted successfully");
    }

    // protected function bulkUpdateStatus(UserStatus $status): void
    // {
    //     $count = $this->service->bulkUpdateStatus(ids: $this->selectedIds, status: $status, actioner: [
    //         'id' => admin()->id,
    //         'type' => Admin::class,
    //     ]);
    //     $this->success("{$count} Datas updated successfully");
    // }

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
