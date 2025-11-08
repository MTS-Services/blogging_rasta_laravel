<section>
    <div class="glass-card rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-black dark:text-text-white">{{ __('Referral Info') }}</h2>
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
    {{-- @dd($user); --}}
    <div class="bg-white shadow rounded-xl p-6 min-h-[500px]">
        {{-- PERSONAL INFO (Default Tab) --}}
        <div class="col-span-1 lg:col-span-2 p-4">
            <h2 class="text-xl font-semibold mb-6 border-b pb-2 text-gray-800">{{__('Referral Information')}}</h2>

            <div class="grid md:grid-cols-3 gap-8 text-base">
                {{-- Referred By --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Referred By')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->referral->referred_by ?? 'N/A' }}</h3>
                </div>

                {{-- referral_code --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Referral Code')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->referral->referral_code ?? 'N/A' }}</h3>
                </div>

                {{-- referral_earnings --}}
                <div>
                    <p class="text-gray-500 mb-1 text-sm uppercase tracking-wider">{{__('Referral_ Earnings')}}</p>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->referral->referral_earnings ?? 'N/A' }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>
