<?php

namespace App\Livewire\Backend\Admin\Settings\Language;

use App\Enums\LanguageStatus;
use App\Services\Admin\LanguageService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Trash extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteLanguageId = null;
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
        $languages = $this->languageService->getTrashedLanguagesPaginated(
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
                'sortable' => true,
                'format' => function ($language) {
                    return $language->native_name
                        ? '<span class="text-sm text-gray-900 dark:text-gray-100">' . $language->native_name . '</span>'
                        : '<span class="text-sm text-gray-400 dark:text-gray-500 italic">N/A</span>';
                }
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
                'format' => function ($language) {
                    $colors = [
                        '1' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        '0' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                    ];
                    $color = $colors[$language->status->value] ?? 'bg-gray-100 text-gray-800';
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' .
                        $language->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'deleted_at',
                'label' => 'Deleted At',
                'sortable' => true,
                'format' => function ($language) {
                    return '<div class="text-sm">' .
                        '<div class="font-medium text-gray-900 dark:text-gray-100">' . $language->deleted_at->format('M d, Y') . '</div>' .
                        '<div class="text-xs text-gray-500 dark:text-gray-400">' . $language->deleted_at->format('h:i A') . '</div>' .
                        '</div>';
                }
            ],
            [
                'key' => 'deleted_by',
                'label' => 'Deleted By',
                'format' => function ($language) {
                    return $language->deleter_admin
                        ? '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $language->deleter_admin->name . '</span>'
                        : '<span class="text-sm text-gray-500 dark:text-gray-400 italic">System</span>';
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'Restore',
                'method' => 'restore',
            ],
            [
                'key' => 'id',
                'label' => 'Permanently Delete',
                'method' => 'confirmDelete'
            ],
        ];

        $bulkActions = [
            ['value' => 'forceDelete', 'label' => 'Permanently Delete'],
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
        ];

        return view('livewire.backend.admin.settings.language.trash', [
            'languages' => $languages,
            'statuses' => LanguageStatus::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }

    public function confirmDelete($languageId): void
    {
        $this->deleteLanguageId = $languageId;
        $this->showDeleteModal = true;
    }

    public function forceDelete(): void
    {
        try {
            $this->languageService->deleteLanguage($this->deleteLanguageId, forceDelete: true);
            $this->showDeleteModal = false;
            $this->deleteLanguageId = null;
            $this->resetPage();

            $this->success('Language permanently deleted successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to delete language: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($languageId): void
    {
        try {
            $this->languageService->restoreLanguage($languageId);

            $this->success('Language restored successfully');
        } catch (\Throwable $e) {
            $this->error('Failed to restore language: ' . $e->getMessage());
            throw $e;
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($languageId, $status): void
    {
        try {
            $languageStatus = LanguageStatus::from($status);

            match ($languageStatus) {
                LanguageStatus::ACTIVE => $this->languageService->activateLanguage($languageId),
                LanguageStatus::INACTIVE => $this->languageService->deactivateLanguage($languageId),
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
            $this->warning('Please select languages and an action');
            Log::info('No languages selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'forceDelete' => $this->bulkForceDeleteLanguages(),
                'bulkRestore' => $this->bulkRestoreLanguages(),
                'activate' => $this->bulkUpdateStatus(LanguageStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(LanguageStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function bulkUpdateStatus(LanguageStatus $status): void
    {
        $count = $this->languageService->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} languages updated successfully");
    }

    protected function bulkRestoreLanguages(): void
    {
        $count = $this->languageService->bulkRestoreLanguages($this->selectedIds);
        $this->success("{$count} languages restored successfully");
    }

    protected function bulkForceDeleteLanguages(): void
    {
        $count = $this->languageService->bulkForceDeleteLanguages($this->selectedIds);
        $this->success("{$count} languages permanently deleted successfully");
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
        return $this->languageService->getTrashedLanguagesPaginated(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
