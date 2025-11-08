<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Game Category Trash List') }}
            </h2>
            <div class="flex items-center gap-2 w-full sm:w-auto">

                <x-ui.button href="{{ route('admin.gm.category.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
                    <span class="sm:inline text-white">{{ __('Back') }}</span>
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Table Component --}}
    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :statuses="$statuses" :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="No Game Category found. Create your first admin to get started." />

    {{-- Delete Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="'Delete this Game Category?'" :message="'Are you absolutely sure you want to remove this Game Category? All associated data will be permanently deleted.'" :method="'delete'"
        :button-text="'Delete Game Category'" />

    {{-- Bulk Action Confirmation Modal --}}
    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="'Confirm Bulk Action'" :message="'Are you sure you want to perform this action on ' . count($selectedIds) . ' selected category(ies)?'" :method="'executeBulkAction'"
        :button-text="'Confirm Action'" />
</section>
