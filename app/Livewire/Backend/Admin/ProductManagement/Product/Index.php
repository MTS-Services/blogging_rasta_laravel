<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Product;

use Livewire\Component;

use App\Enums\ProductStatus;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Services\ProductService;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{

    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;


    protected ProductService $service;

    public function boot(ProductService $service)
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
                'key' => 'title',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'description',
                'label' => 'Description',
                'sortable' => true
            ],
            [
                'key' => 'price',
                'label' => 'Price',
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
                'label' => 'Show',
                'route' => 'admin.pm.product.show',
                'encrypt' => true
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.pm.product.edit',
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
            ['value' => 'draft', 'label' => 'Draft'],
            ['value' => 'pending_review', 'label' => 'Pending Review'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
            ['value' => 'rejected', 'label' => 'Rejected'],
            ['value' => 'sold_out', 'label' => 'Sold Out'],

        ];
        return view('livewire.backend.admin.product-management.product.index', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => ProductStatus::options(),
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
    public function changeStatus($id, $status): void
    {
        try {
            $productStatus = ProductStatus::from($status);

            match ($productStatus) {
                ProductStatus::DRAFT => $this->service->updateStatusData($id, ProductStatus::DRAFT),
                ProductStatus::PENDING_REVIEW => $this->service->updateStatusData($id, ProductStatus::PENDING_REVIEW),
                ProductStatus::ACTIVE => $this->service->updateStatusData($id, ProductStatus::ACTIVE),
                ProductStatus::INACTIVE => $this->service->updateStatusData($id, ProductStatus::INACTIVE),
                ProductStatus::REJECTED => $this->service->updateStatusData($id, ProductStatus::REJECTED),
                ProductStatus::SOLD_OUT => $this->service->updateStatusData($id, ProductStatus::SOLD_OUT),
                default => null,
            };

            $this->success('Data status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
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
                'draft' => $this->bulkUpdateStatus(ProductStatus::DRAFT),
                'pending_review' => $this->bulkUpdateStatus(ProductStatus::PENDING_REVIEW),
                'active' => $this->bulkUpdateStatus(ProductStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(ProductStatus::INACTIVE),
                'rejected' => $this->bulkUpdateStatus(ProductStatus::REJECTED),
                'sold_out' => $this->bulkUpdateStatus(ProductStatus::SOLD_OUT),
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

    protected function bulkUpdateStatus(ProductStatus $status): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Data updated successfully");
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
