<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Statistic Info') }}</h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Tab Navigation Bar --}}
    @include('backend.admin.pages.user-management.user.nav')
    <div class="bg-white shadow rounded-xl p-6 min-h-[500px]">
        {{-- PERSONAL INFO (Default Tab) --}}
        <div class="col-span-1 lg:col-span-2 p-4">
            <h2 class="text-xl font-semibold mb-6 border-b pb-2 text-gray-800">{{__('Statistics Information')}}</h2>

            <div class="grid md:grid-cols-3 gap-8 text-base">
                {{-- total_orders_as_buyer --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Total Orders as Buyer')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->statistic->total_orders_as_buyer ?? 'N/A' }}
                    </h3>
                </div>

                {{-- total_spent --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Total Spent')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->statistic->total_spent ?? 'N/A' }}</h3>
                </div>

                {{-- total_orders_as_seller --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Total Orders as Seller')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $user->statistic->total_orders_as_seller ?? 'N/A' }}
                    </h3>
                </div>

                {{-- total_earned --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Total Earned')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->statistic->total_earned ?? 'N/A' }}
                    </h3>
                </div>

                {{-- average_rating_as_seller --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Average Rating as Seller')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $user->statistic->average_rating_as_seller ?? 'N/A' }}
                    </h3>
                </div>

                {{-- total_reviews_as_seller --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Total Reviews as Seller')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $user->statistic->total_reviews_as_seller ?? 'N/A' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>
