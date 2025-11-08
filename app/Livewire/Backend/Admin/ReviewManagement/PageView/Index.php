<?php

namespace App\Livewire\Backend\Admin\ReviewManagement\PageView;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Services\PageViewService;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;


    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;



    protected PageViewService $service;

    public function boot(PageViewService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $datas = $this->service->getPaginatedData(
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
                'sortable' => true,
                'format' => function ($data) {
                    return $data->viewer?->user_type ?? 'Guest';
                }
            ],
            [
                'key' => 'viewer_id',
                'label' => 'Viewer ID',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->viewer?->name ?? 'N/A';
                }
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
                'label' => 'Show',
                'route' => 'admin.rm.review.show',
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

        ];
        return view('livewire.backend.admin.review-management.page-view.index', [
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
            $this->warning('Please select data and an action');
            Log::info('No data selected or no bulk action selected');
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
        $count = count($this->selectedIds);
        $this->service->bulkDeleteData($this->selectedIds);
        $this->success("{$count} Data deleted successfully");
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
        return $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
