<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Blog Category Trash List') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.blog-category.index') }}" class="w-auto py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <x-ui.table :data="$datas" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" :bulkAction="$bulkAction"
        :selectedIds="$selectedIds" :mobileVisibleColumns="2" searchProperty="search" perPageProperty="perPage"
        :showBulkActions="true" emptyMessage="{{ __('No data found. Delete your first data to get started.') }}" />

    <x-ui.confirmation-modal :show="'showDeleteModal'" :title="__('Permanently delete this data?')" :message="__('Are you absolutely sure you want to delete this data? All associated data will be permanently deleted.')" :method="'forceDelete'"
        :button-text="__('Permanently Delete')" />

    <x-ui.confirmation-modal :show="'showBulkActionModal'" :title="__('Confirm Bulk Action')" :message="__('Are you sure you want to perform this action on ') . count($selectedIds) . __(' selected data(s)?')" :method="'executeBulkAction'"
        :button-text="__('Confirm Action')" />
</section>
