<div>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">TikTok Videos</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage and sync TikTok videos</p>
        </div>

        {{-- Sync Button --}}
        <div>
            <x-ui.button wire:click="syncVideos" variant="primary" class="w-full sm:w-auto">
                <span wire:loading.remove wire:target="syncVideos">
                    <flux:icon icon="arrow-path" class="w-4 h-4" />
                </span>
                <span wire:loading wire:target="syncVideos">
                    <flux:icon icon="arrow-path" class="w-4 h-4 animate-spin" />
                </span>
                {{ __('Sync Videos') }}
            </x-ui.button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <div class="flex items-center gap-2">
                <flux:icon icon="check-circle" class="w-5 h-5 text-green-600 dark:text-green-400" />
                <span class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
            <div class="flex items-center gap-2">
                <flux:icon icon="x-circle" class="w-5 h-5 text-red-600 dark:text-red-400" />
                <span class="text-sm font-medium text-red-800 dark:text-red-200">
                    {{ session('error') }}
                </span>
            </div>
        </div>
    @endif

    {{-- Data Table --}}
    <x-ui.table :columns="$columns" :data="$videos" :actions="$actions" :statuses="$statuses" :bulkActions="$bulkActions"
        searchProperty="search" perPageProperty="perPage" :showSearch="true" :showPerPage="true" :showBulkActions="true"
        :perPageOptions="[10, 15, 20, 50, 100]" emptyMessage="No videos found. Click 'Sync Videos' to fetch from TikTok." :mobileVisibleColumns="3" />
</div>
