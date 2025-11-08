<div class="space-y-6">

    <div x-transition:enter="transition ease-out duration-100"
        class="bg-bg-primary backdrop:blure-md z-100  transition-all duration-300 min-h-screen text-text-text-white shadow-lg p-4 sm:p-8 md:p-12 lg:p-16 xl:p-20 rounded-2xl">
        <div class="mb-2">
            <!-- Header -->
            <div x-data="{ filter: 'all' }">
                <div class="flex gap-2 sm:gap-4 items-center">
                    <div class="flex justify-between items-center p-4 mb-10 pb-0">
                        <h2 class="text-xl sm:text-3xl font-semibold text-text-white">{{ __('Notifications') }}</h2>
                    </div>
                    <div class="mb-3">
                        <button @click="filter = 'all'"
                            :class="filter === 'all' ? 'bg-pink-500' : 'bg-bg-secondary'"
                            class="text-sm text-text-white px-2.5 py-1.5 sm:px-5 sm:py-2.5 rounded">
                            {{ __('All') }}
                        </button>
                        <button @click="filter = 'unread'"
                            :class="filter === 'unread' ? 'bg-pink-500' : 'bg-bg-secondary'"
                            class="text-sm text-text-white px-2.5 py-1.5 sm:px-5 sm:py-2.5 rounded">
                            {{ __('Unread') }}
                        </button>
                        <button @click="filter = 'read'"
                            :class="filter === 'read' ? 'bg-pink-500' : 'bg-bg-secondary'"
                            class="text-sm text-text-white px-2.5 py-1.5 sm:px-5 sm:py-2.5 rounded">
                            {{ __('Read') }}
                        </button>
                    </div>
                </div>

                <!-- Notification List -->
                <div class="space-y-2 h-full overflow-y-auto pr-1">
                    @for ($i = 0; $i < 10; $i++)
                        <div x-show="filter === 'all' || (filter === 'unread' && {{ $i % 2 === 0 ? 'true' : 'false' }}) || (filter === 'read' && {{ $i % 2 !== 0 ? 'true' : 'false' }})"
                            class="flex gap-2 md:gap-4 hover:bg-zinc-800/50 rounded-xl p-4 {{ $i % 2 === 0 ? 'bg-zinc-800/30' : '' }}">
                            <div class="shrink-0">
                                {{-- Notification icon --}}
                                <div class="w-10 h-10 bg-zinc-800/50 rounded-full flex items-center justify-center">
                                    <flux:icon name="bell" class="w-5 h-5 text-zinc-400" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-sm sm:text-base text-text-white">{{ __('Digimon Super Rumble is HERE!') }}</h3>
                                <p class="text-sm text-text-white dark:text-zinc-200/60 mt-1 leading-relaxed">
                                    {{ __('Hello dear sellers, just now we\'ve added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now.') }}
                                </p>
                            </div>
                            <div class="shrink-0">
                                <span class="text-xs text-pink-500 whitespace-nowrap">9min ago</span>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <div>
        {{-- <x-frontend.pagination-ui :pagination="$pagination" /> --}}
    </div>

</div>
