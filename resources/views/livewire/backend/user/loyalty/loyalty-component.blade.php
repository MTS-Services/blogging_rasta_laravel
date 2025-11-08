
<div class="min-h-screen py-8 px-4">
    <div class="">
        {{-- Top Cards Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Bronze Level Card --}}
            <div class="bg-bg-primary rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-text-primary font-open-sans text-lg">{{ __('How it works?') }}</h3>
                    <div class="flex items-center gap-2 bg-zinc-50/10 px-3 py-1.5 rounded-full">
                        <x-phosphor-coin class="fill-yellow-500 w-5 h-5" weight="fill" />
                        <span class="text-text-white font-semibold">500</span>
                    </div>
                </div>

                <div class="flex justify-center mb-6">
                    <div class="relative">
                        <div class="w-26 h-26 rounded-full flex items-center justify-center shadow-lg">
                            <img src="{{ asset('assets/images/loyalty_card.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h4 class="text-text-white font-semibold text-xl mb-2">{{ __('Bronze') }}</h4>
                    <div class="text-text-white text-sm">500/2400</div>
                    <div class="w-70 xl:w-90 mx-auto bg-white rounded-full h-2 mt-2">
                        <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 20%">
                        </div>
                    </div>
                </div>

                <p class="text-text-white text-center text-sm">
                    {{ __('You need an additional 1,900 points to reach the Silver level.') }}
                </p>
            </div>

            {{-- Available Points Card --}}
            <div class="rounded-3xl p-8 bg-pink-200 dark:bg-pink-900">
                <div class="mb-6">
                    <h3 class="text-text-white font-semibold text-xl mb-4">{{ __('Available points') }}</h3>
                    <div class="flex items-center gap-2">
                        <x-phosphor-coin class="fill-yellow-500 w-6 h-6" weight="fill" />
                        <span class="text-text-white font-bold text-3xl">500</span>
                    </div>
                </div>

                <p class="text-text-white/90 text-sm mb-6">
                    {{ __('Collect a minimum of 10,000 points and unlock a $1 reward.') }}
                </p>

                <div class="border-t-3 border-pink-600 mb-6"></div>

                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-text-white font-bold text-2xl mb-1">{{ __('10,000 points') }}</div>
                        <div class="text-text-white/70 text-sm">{{ __('$1 Store credit') }}</div>
                    </div>
                    <x-ui.button class="sm:w-auto! py-2!">
                        {{ __('Redeem') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        {{-- Achievements Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-text-white font-open-sans text-2xl font-bold">{{ __('Achievements completed') }}</h2>
            </div>
            <p class="text-text-white text-sm ">0 / 10 {{ __('completed') }}</p>
        </div>

        {{-- Achievement Cards Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Critic Achievement --}}
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-20 h-20 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('assets/images/loyalty_icon.png') }}" alt="" class="w-full h-full">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-text-white font-semibold font-lato text-lg sm:text-3xl mb-1">{{ __('Critic') }}</h4>
                        <p class="text-text-white text-sm sm:text-base">{{ __('Write reviews for sellers') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-white text-base sm:text-xl">{{ __('0 / 1 To unlock') }}</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="fill-yellow-500 w-4 h-4" weight="fill" />
                        <span class="text-text-white font-semibold text-base sm:text-xl">+500</span>
                    </div>
                </div>
                <div class="w-full bg-white rounded-full h-2">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-20 h-20 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('assets/images/loyalty_icon.png') }}" alt="" class="w-full h-full">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-text-white font-semibold font-lato text-lg sm:text-3xl mb-1">{{ __('Explorer') }}</h4>
                        <p class="text-text-white text-sm sm:text-base">{{ __('Place your first order in each category') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-white text-base sm:text-xl">{{ __('0 / 1 To unlock') }}</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="fill-yellow-500 w-4 h-4" weight="fill" />
                        <span class="text-text-white font-semibold text-base sm:text-xl">+500</span>
                    </div>
                </div>
                <div class="w-full bg-white rounded-full h-2">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-20 h-20 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('assets/images/loyalty_icon.png') }}" alt="" class="w-full h-full">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-text-white font-semibold font-lato text-lg sm:text-3xl mb-1">{{ __('Speedrunner') }}</h4>
                        <p class="text-text-white text-sm sm:text-base">{{ __('Place 2 orders in one month') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-white text-base sm:text-xl">{{ __('0 / 1 To unlock') }}</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="fill-yellow-500 w-4 h-4" weight="fill" />
                        <span class="text-text-white font-semibold text-base sm:text-xl">+500</span>
                    </div>
                </div>
                <div class="w-full bg-white rounded-full h-2">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6 border border-primary-700/30">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-20 h-20 rounded-xl bg-primary-800/50 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('assets/images/loyalty_icon.png') }}" alt="" class="w-full h-full">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-text-white font-semibold font-lato text-lg sm:text-3xl mb-1">{{ __('Master Trader') }}</h4>
                        <p class="text-text-white text-sm sm:text-base">{{ __('Place 2 Eldorado orders') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-text-white text-base sm:text-xl">{{ __('0 / 1 To unlock') }}</span>
                    <div class="flex items-center gap-1">
                        <x-phosphor-coin class="fill-yellow-500 w-4 h-4" weight="fill" />
                        <span class="text-text-white font-semibold text-base sm:text-xl">+500</span>
                    </div>
                </div>
                <div class="w-full bg-white rounded-full h-2">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-2 rounded-full" style="width: 0%"></div>
                </div>
            </div>
        </div>

        {{-- Dedication Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-text-white font-open-sans text-2xl font-bold">{{ __('Dedication') }}</h2>
            </div>
            <p class="text-text-white text-sm">{{ __('Purchase at least 2 products per game to earn points') }}</p>
        </div>

        {{-- CTA Card --}}
        <div
            class="glass-card rounded-2xl p-8 py-12 bg-gradient-to-r from-pink-500/20 to-pink-800 text-center">
            <h2 class="text-text-white font-open-sans text-3xl xl:text-4xl font-bold mb-6">
                {{ __('Start Your Reward Journey Today') }}
            </h2>
            <p class="text-text-white max-w-3xl font-open-sans text-xl font-normal mx-auto mb-6">
                {{ __('Make your first purchase today and start tracking your journey toward exciting rewards. Each order helps you unlock new levels, bonuses, and exclusive offers. Stay motivated and see your progress grow with every step!') }}
            </p>

            <x-ui.button class="sm:w-auto! py-2! mt-6 mx-auto">
                {{ __('Browse for more') }}
            </x-ui.button>
        </div>
    </div>
</div>
