<div>
    {{-- Page Header --}}
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">TikTok Videos</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage and sync TikTok videos</p>
        </div>
        {{-- Sync Button --}}
        <div>
            <x-ui.button wire:click="syncVideos" variant="primary" class="w-full py-2! sm:w-auto">
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

    {{-- Data Table --}}
    <x-ui.table :columns="$columns" :data="$videos->map(function ($video) use ($actionsMap) {
        $video->dynamicActions = $actionsMap[$video->id] ?? [];
        return $video;
    })" :actions="[]" :statuses="$statuses" :bulkActions="$bulkActions"
        searchProperty="search" perPageProperty="perPage" :showSearch="true" :showPerPage="true" :showBulkActions="true"
        :perPageOptions="[10, 15, 20, 50, 100]" emptyMessage="No videos found. Click 'Sync Videos' to fetch from TikTok." :mobileVisibleColumns="3" />
</div>
