<?php

namespace App\Livewire\Backend\Admin\BlogCategory;

use App\Services\BlogCategoryService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected BlogCategoryService $service;

    public function boot(BlogCategoryService $service)
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
                'key' => 'status',
                'label' => __('Status'),
                'sortable' => true,
                'format' => function ($data) {
                    $badge = $data->status === 'active' ? 'badge-success' : 'badge-secondary';
                    return '<span class="badge badge-soft ' . $badge . '">' . $data->status . '</span>';
                },
            ],
            [
                'key' => 'created_at',
                'label' => __('Created Date'),
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                },
            ],
            [
                'key' => 'created_by',
                'label' => __('Created By'),
                'format' => function ($data) {
                    return $data->creater_admin?->name ?? 'System';
                },
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => __('Show'),
                'route' => 'admin.blog-category.view',
                'encrypt' => true,
            ],
            [
                'key' => 'id',
                'label' => __('Edit'),
                'route' => 'admin.blog-category.edit',
                'encrypt' => true,
            ],
            [
                'key' => 'id',
                'label' => __('Delete'),
                'method' => 'confirmDelete',
                'encrypt' => true,
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => __('Delete')],
        ];

        return view('livewire.backend.admin.blog-category.index', [
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
        try {
            if (! $this->deleteId) {
                $this->warning(__('No data selected'));
                return;
            }
            $this->service->deleteData(decrypt($this->deleteId));
            $this->reset(['deleteId', 'showDeleteModal']);
            $this->success(__('Data deleted successfully'));
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
            $this->warning(__('Please select data and an action'));
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
        $count = $this->service->bulkDeleteData($this->selectedIds);
        $this->success("{$count} " . __('Data deleted successfully'));
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
