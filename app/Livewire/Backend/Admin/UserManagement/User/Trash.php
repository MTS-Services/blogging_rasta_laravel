<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use App\Models\Admin;
use Livewire\Component;
use App\Enums\UserAccountStatus;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Throwable;

class Trash extends Component
{

    use WithDataTable, WithNotification;


    protected UserService $service;

    public $statusFilter = '';
    public $userId;
    public $bulkAction = '';
    public $showDeleteModal = false;
    public $showBulkActionModal = false;

    public function boot(UserService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $users = $this->service->getTrashedPaginateDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        // $users = $this->userService->getAllUsers();

        $columns = [
            [
                'key' => 'first_name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'username',
                'label' => 'User Name',
                'sortable' => true
            ],
            [
                'key' => 'email',
                'label' => 'Email',
                'sortable' => true
            ],
            [
                'key' => 'phone',
                'label' => 'Phone',
                'sortable' => true
            ],
            [
                'key' => 'country_id',
                'label' => 'Country Name',
                'sortable' => true,
                'format' => function ($user) {
                    return $user->country->name;
                }
            ],
            [
                'key' => 'account_status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($user) {
                    $colors = [
                        'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        'suspended' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                    ];
                    $color = $colors[$user->account_status->value] ?? 'bg-gray-100 text-gray-800';
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' .
                        ucfirst($user->account_status->value) .
                        '</span>';
                }
            ],
        ];
        $actions = [
            [
                'key' => 'id',
                'label' => 'Restore',
                'method' => 'restore'
            ],
            [
                'key' => 'id',
                'label' => 'Confirm Delete',
                'method' => 'confirmDelete'
            ],
        ];
        $bulkActions = [
            ['value' => 'bulkRestore', 'label' => 'Restore'],
            ['value' => 'bulkForceDelete', 'label' => 'Permanently Delete'],
            ['value' => 'activate', 'label' => 'Activate'],
            ['value' => 'deactivate', 'label' => 'Deactivate'],
            ['value' => 'suspend', 'label' => 'Suspend'],

        ];
        return view('livewire.backend.admin.user-management.user.trash', [
            'users' => $users,
            'columns' => $columns,
            'statuses' => UserAccountStatus::options(),
            'actions' => $actions,
            'bulkActions' => $bulkActions,

        ]);
    }
    public function confirmDelete($userId): void
    {
        $this->userId = $userId;
        $this->showDeleteModal = true;
    }

    public function forceDelete(): void
    {
        try {
            $this->service->deleteData($this->userId, forceDelete: true);
            $this->showDeleteModal = false;
            $this->resetPage();

            $this->success('User permanently deleted successfully');
        } catch (Throwable $e) {
            $this->error('Failed to delete user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function restore($userId): void
    {
        try {
            $this->service->restoreData($userId, admin()->id);

            $this->success('User restored successfully');
        } catch (Throwable $e) {
            $this->error('Failed to restore user: ' . $e->getMessage());
            throw $e;
        }
    }
    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function changeStatus($userId, $status): void
    {
        try {
            $userStatus = UserAccountStatus::from($status);

            match ($userStatus) {
                UserAccountStatus::ACTIVE => $this->service->activateData($userId),
                UserAccountStatus::INACTIVE => $this->service->deactivateData($userId),
                UserAccountStatus::SUSPENDED => $this->service->suspendData($userId),
                default => null,
            };

            $this->success('User status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select Users and an action');
            Log::info('No Users selected or no bulk action selected');
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
                'activate' => $this->bulkUpdateStatus(UserAccountStatus::ACTIVE),
                'deactivate' => $this->bulkUpdateStatus(UserAccountStatus::INACTIVE),
                'suspend' => $this->bulkUpdateStatus(UserAccountStatus::SUSPENDED),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }
    protected function bulkUpdateStatus(UserAccountStatus $status): void
    {
        $count = $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} Users updated successfully");
    }
    protected function bulkRestoreDatas(): void
    {
        $count = $this->service->bulkRestoreDatas($this->selectedIds, admin()->id);
        $this->success("{$count} Users restored successfully");
    }
    protected function bulkForceDeleteDatas(): void
    {
        $count = $this->service->bulkForceDeleteDatas($this->selectedIds);
        $this->success("{$count} Users permanently deleted successfully");
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'account_status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }

    // protected function getSelectableIds(): array
    // {
    //     return $this->userService->getUsersPaginated(
    //         perPage: $this->perPage,
    //         filters: $this->getFilters()
    //     )->pluck('id')->toArray();
    // }

    public function getSelectableIds(): array
    {
        return $this->service->getTrashedPaginateDatas(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->pluck('id')->toArray();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
