<div class="space-y-6">
    <div class=" p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All Game') }}</option>
                        <option value="game1">{{ __('Game 1') }}</option>
                        <option value="game2">{{ __('Game 2') }}</option>
                        <option value="game3">{{ __('Game 3') }}</option>
                    </x-ui.select>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All') }}</option>
                        <option value="active">{{ __('Active offers') }}</option>
                        <option value="paused">{{ __('Paused offers') }}</option>
                        <option value="closed">{{ __('Closed offers') }}</option>
                    </x-ui.select>
                </div>

                <!-- Recommended Filter -->
                <div class="relative w-full sm:w-44 lg:w-48">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('Recommended') }}</option>
                        <option value="price_low">{{ __('Price: Low to High') }}</option>
                        <option value="price_high">{{ __('Price: High to Low') }}</option>
                        <option value="newest">{{ __('Newest First') }}</option>
                    </x-ui.select>
                </div>
                <div class="relative w-full sm:w-56">
                    <x-ui.input type="text" placeholder="{{ __('Search') }}" class="pl-5 py-1.5! text-text-white" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-phosphor-magnifying-glass class="w-5 h-5 fill-text-text-white" />
                    </div>
                </div>
            </div>

            <!-- Right Side: Search & Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                <!-- Export Button -->
                <x-ui.button variant="secondary" class="sm:w-auto! py-2!">
                    <x-phosphor-download class="w-5 h-5 fill-accent group-hover:fill-white" />
                    <span class="text-text-btn-secondary group-hover:text-text-btn-primary">{{ __('Export') }}</span>
                </x-ui.button>

                <!-- New Offer Button -->
                <x-ui.button class="w-full sm:w-auto! py-2!">
                    <x-phosphor-plus class="w-5 h-5 fill-text-text-white group-hover:fill-accent" />
                    <span class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('New Offer') }}</span>
                </x-ui.button>

            </div>
        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns" :actions="$actions"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
                    wire:click="$set('showDeleteModal', false)"></div>

                {{-- Modal panel --}}
                <div
                    class="inline-block align-bottom bg-bg-primary rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-bg-primary px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-text-white" id="modal-title">
                                    {{ __('Delete Item') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-text-muted">
                                       {{ __(' Are you sure you want to delete this item? This action cannot be undone.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-bg-secondary px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="button" wire:click="deleteItem"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Delete') }}
                        </button>
                        <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-zinc-700 shadow-sm px-4 py-2 bg-bg-primary text-base font-medium text-text-white hover:bg-bg-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
