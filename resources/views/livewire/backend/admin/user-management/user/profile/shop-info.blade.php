<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Shop Info') }}</h2>
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
            <h2 class="text-xl font-semibold mb-6 border-b pb-2 text-gray-800">{{__('Shop Information')}}</h2>

            <div class="grid md:grid-cols-3 gap-8 text-base">
                {{-- Shop Name --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Shop Name')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $user->seller->shop_name ?? 'No shop name found' }}
                    </h3>
                </div>

                {{-- Seller Verified --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Seller Verified')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->seller->seller_verified ?? 'N/A' }}</h3>
                </div>

                {{-- Verified At --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Verified At')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->seller->seller_verified_at ?? 'N/A' }}
                    </h3>
                </div>

                {{-- Seller Level --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Seller Level')}}</p>
                    <h3
                        class="text-lg font-medium text-gray-900 badge badge-soft {{ $user->seller->seller_level_color ?? 'N/A' }}">
                        {{ $user->seller->seller_level_label ?? 'N/A' }}
                    </h3>
                </div>

                {{-- commission_rate --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Commission Rate')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $user->seller->commission_rate ?? 'N/A' }}
                    </h3>
                </div>

                {{-- minimum_payout --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Minimum payout')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $user->seller->minimum_payout ?? 'N/A' }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="mt-8">
            {{-- description --}}
            <div>
                <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Description')}}</p>
                <p class="text-sm font-medium text-gray-600">{{ $user->seller->shop_description ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>
    </div>
</section>
