<div class="space-y-6">
    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="relative" id="dropdown-wrapper">
            <x-ui.select id="status-select" class="py-0.5! w-full sm:w-70">
                <option value="">{{ __('All statuses') }}</option>
                <option value="completed">{{ __('Completed') }}</option>
                <option value="pending">{{ __('Pending') }}</option>
                <option value="processing">{{ __('Processing') }}</option>
            </x-ui.select>
            <div id="icon-container" class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>

        <div class="relative">
            <x-ui.select class="py-0.5! w-full sm:w-70">
                <option value="">{{ __('Recent') }}</option>
                <option value="today">{{ __('Today') }}</option>
                <option value="week">{{ __('This Week') }}</option>
                <option value="month">{{ __('This Month') }}</option>
            </x-ui.select>
            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                <flux:icon name="chevron-down" class="w-4 h-4 text-gray-300" stroke="white" />
            </div>
        </div>
    </div>

    <div>
        <x-ui.user-table :data="$items" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />

        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>

</div>
