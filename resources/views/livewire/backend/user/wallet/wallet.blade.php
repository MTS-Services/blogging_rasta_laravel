<div class="space-y-6">
    {{-- Balance card --}}
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Balance Card -->
        <div class="w-full md:w-1/2 bg-bg-primary rounded-2xl p-6 md:p-10">
            <div class="dark:bg-zinc-50/10 bg-zinc-200 rounded-2xl p-5 md:p-7">
                <div class="dark:bg-zinc-50/15 bg-zinc-50 rounded-2xl p-5 md:p-7">
                    <div class="flex flex-col lg:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-text-white">{{__('Balance')}}</p>
                            <h2 class="text-text-white text-2xl font-semibold mt-2">$12.00</h2>
                            <p class="text-text-white mt-2 text-sm md:text-base">{{__('Withdrawals require $10 in completed
                                sales')}}</p>
                            <a href="#" class="text-pink-500 mt-2 inline-block">{{__('Learn more')}}</a>
                        </div>
                        <div>
                            <x-ui.button class="w-full sm:w-auto py-2!">
                                <span
                                    class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Withdraw') }}</span>
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Sales Card -->
        <div class="w-full md:w-1/2 bg-bg-primary rounded-2xl p-6 md:p-10">
            <div class="dark:bg-zinc-50/10 bg-zinc-200 rounded-2xl p-5 md:p-7">
                <div class="dark:bg-zinc-50/15 bg-zinc-50 rounded-2xl p-5 md:p-7">
                    <h2 class="text-text-white text-2xl font-semibold">{{__('Pending Sales')}}</h2>
                    <p class="text-text-white mt-2 text-sm md:text-base">
                        {{ __('Revenue from pending orders. Funds will be added to your balance when orders are Completed.') }}
                    </p>
                    <h2 class="text-text-white text-2xl font-semibold mt-2">$5.00</h2>
                </div>
            </div>
        </div>
    </div>

    <div class=" p-4 w-full">
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-3 lg:gap-4">

            <!-- Left Side: Filters -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <!-- Game Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('All') }}</option>
                        <option value="game1">{{ __('Purchases') }}</option>
                        <option value="game2">{{ __('Salsas') }}</option>
                        <option value="game3">{{ __('Withdrawals') }}</option>
                    </x-ui.select>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full sm:w-40 lg:w-44">
                    <x-ui.select class="bg-surface-card border border-border-primary py-1.5! rounded-lg">
                        <option value="">{{ __('Select Month') }}</option>
                        <option value="January">{{ __('January') }}</option>
                        <option value="February">{{ __('February') }}</option>
                        <option value="April">{{ __('April') }}</option>
                        <option value="May">{{ __('May') }}</option>
                        <option value="June">{{ __('June') }}</option>
                        <option value="July">{{ __('July') }}</option>
                        <option value="August">{{ __('August') }}</option>
                        <option value="September">{{ __('September') }}</option>
                        <option value="October">{{ __('October') }}</option>
                        <option value="November">{{ __('November') }}</option>
                        <option value="December">{{ __('December') }}</option>
                    </x-ui.select>
                </div>
            </div>

            <!-- Right Side: Search & Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                <!-- Manage Subscriptions Button -->
                <x-ui.button class="w-full sm:w-auto! py-2!">
                    <span
                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Manage Subscriptionsr') }}</span>
                </x-ui.button>

            </div>
        </div>
    </div>
    <div>
        <x-ui.user-table :data="$items" :columns="$columns"
            emptyMessage="No data found. Add your first data to get started." class="rounded-lg overflow-hidden" />
        <x-frontend.pagination-ui :pagination="$pagination" />
    </div>

</div>
