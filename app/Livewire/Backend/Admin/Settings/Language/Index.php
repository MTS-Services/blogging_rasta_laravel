<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\Enums\LanguageStatus;
use App\Services\LanguageService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteAdminId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;

    protected $listeners = ['languageCreated' => '$refresh', 'languageUpdated' => '$refresh'];

    protected LanguageService $languageService;

    public function boot(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function render()
    {
        $datas = $this->languageService->getPaginatedData(
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
                'key' => 'native_name',
                'label' => 'Native Name',
                'sortable' => true
            ],
            [
                'key' => 'locale',
                'label' => 'Locale',
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
                'key' => 'created_at',
                'label' => 'Created Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
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
                'label' => 'View',
                'route' => 'admin.as.language.view',
            ],
            [
                'key' => 'id',
                'label' => 'Edit',
                'route' => 'admin.as.language.edit'
            ],
            [
                'key' => 'id',
                'label' => 'Delete',
                'method' => 'confirmDelete'
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.settings.language.index', [
            'datas' => $datas,
            'statuses' => LanguageStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    public function confirmDelete($laguageId): void
    {
        $this->deleteAdminId = $laguageId;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        // dd($this->deleteAdminId);
        try {
            if (!$this->deleteAdminId) {
                return;
            }

            if ($this->deleteAdminId == admin()->id) {
                $this->error('You cannot delete your own account');
                return;
            }

            $this->languageService->deleteData($this->deleteAdminId);

            $this->showDeleteModal = false;
            $this->deleteAdminId = null;

            $this->success('Language deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete Admin: ' . $e->getMessage());
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($laguageId, $status): void
    {
        try {
            $LanguageStatus = LanguageStatus::from($status);

            match ($LanguageStatus) {
                LanguageStatus::ACTIVE => $this->languageService->getActiveData($laguageId),
                LanguageStatus::INACTIVE => $this->languageService->getInactiveData($laguageId),
                default => null,
            };

            $this->success('Language status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Admins and an action');
            Log::info('No Admins selected or no bulk action selected');
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
                'active' => $this->bulkUpdateStatus(LanguageStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(LanguageStatus::INACTIVE),
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
        $count = $this->languageService->bulkDeleteData($this->selectedIds);
        $this->success("{$count} Languages deleted successfully");
    }

    protected function bulkUpdateStatus(LanguageStatus $status): void
    {
        $count = $this->languageService->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Languages updated successfully");
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
        return $this->languageService->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
