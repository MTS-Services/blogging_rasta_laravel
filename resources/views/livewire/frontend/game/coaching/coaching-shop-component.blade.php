<!-- Breadcrumb -->
<div class="flex items-center gap-2 mb-8 text-lg font-semibold">
    <h1 class="text-blue-100 text-text-primary">
        {{$gameName . ' ' . ucwords(request()->get('game-category'))}}
    </h1>
    <span class="text-text-primary">></span>
    <span class="text-text-primary">{{ __('Seller list') }}</span>
</div>

<!-- Filters Section -->
<div class="mb-8 space-y-4">
    <div class="flex gap-4 flex-wrap">
        <div class="flex-1 min-w-64">
            <div class="relative">
                <input type="text" placeholder="{{ __('Search') }}"
                    class="w-full bg-bg-primary border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-purple-500">
                <span class="absolute left-3 top-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
            </div>
        </div>

        <x-ui.select id="device-select" class="py-0.5! w-auto! rounded-full!">
            <option value="">{{ __('Device') }}</option>
        </x-ui.select>

        <x-ui.select id="account-type-select" class="py-0.5! w-auto! rounded-full!">
            <option value="">{{ __('Account type') }}</option>
        </x-ui.select>

        <x-ui.select id="price-select" class="py-0.5! w-auto! rounded-full!">
            <option value="">{{ __('Price') }}</option>
        </x-ui.select>

        <x-ui.select id="delivery-select" class="py-0.5! w-auto! rounded-full!">
            <option value="">{{ __('Select Delivery Time') }}</option>
        </x-ui.select>

        <button class="text-text-primary hover:text-white transition">{{ __('Clear all') }}</button>
    </div>

    <!-- Game Tags -->
    <div class="flex gap-2 flex-wrap">
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Robux') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Steel A Brainrot') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Grow A Garden') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Hunty Zombie') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('99 Nights In The Forest') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Prospecting') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('All Star Tower Defense X') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Ink Game') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Garden Tower Defense') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Bubble Gum Simulator') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Dead Rails') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('TYPE./ ISOUL') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Hypershot') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Build A Zoo') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Gems') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Rivals') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('MM2') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Blox Fruit') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Pet Simulator 99') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Spin') }}</span>
        <span class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white cursor-pointer">{{ __('Adopt Me') }}</span>
    </div>

    <!-- Right Filters -->
    <div class="flex gap-3 justify-end">
        <button class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">● {{ __('Online Seller') }}</button>

        <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
            <option value="">{{ __('All statuses') }}</option>
            <option value="completed">{{ __('Completed') }}</option>
            <option value="pending">{{ __('Pending') }}</option>
            <option value="processing">{{ __('Processing') }}</option>
        </x-ui.select>
    </div>
</div>


<!-- Product Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card 1 -->
    <a href="{{ route('boost.buy-now') }}" wire:navigate>
        <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
            <h3 class="text-lg font-medium mb-3">
                {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
            </h3>
            <div class="flex gap-1 text-sm text-text-secondary py-4">
                <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
                </span>
                <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    {{ __('Pickaxes') }}: 0-10
                </span>
                <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    {{ __('Outfits') }}: {{ __('None') }}
                </span>
            </div>
            <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
                <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
                <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
                </span>
            </div>
            <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                <img src="{{ asset('assets/images/Victoria.png') }}" alt="Esther" class="w-10 h-10 rounded-full">
                <div>
                    <p class="font-semibold text-text-white">{{__('Victoria')}}</p>
                    <p class="text-sm text-text-secondary">
                        <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                        99.3% | 2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                    </p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card 2 -->
    <a href="{{ route('boost.buy-now') }}" wire:navigate>
        <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
            <h3 class="text-lg font-medium mb-3">
                {{ __('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra Fast Delivery. Text me for info. Do not purchase directly.') }}
            </h3>
            <div class="flex gap-4 text-sm text-slate-400 py-4">
                <span class="flex items-center gap-1 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
                </span>
                <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    {{ __('Pickaxes') }}: 0-10
                </span>
                <span class="flex items-center gap-1 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    {{ __('Outfits') }}: {{ __('None') }}
                </span>
            </div>
            <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
                <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
                <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                    <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
                </span>
            </div>
            <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                <img src="{{ asset('assets/images/Colleen.png') }}" alt="Esther" class="w-10 h-10 rounded-full">
                <div>
                    <p class="font-semibold text-text-white">Colleen</p>
                    <p class="text-sm text-text-secondary">
                        <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                        99.3% | 2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                    </p>
                </div>
            </div>
        </div>
    </a>
</div>


<!-- Card 3 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Esther.png') }}" alt="Esther" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Esther')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>

<!-- Card 4 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Shane.png') }}" alt="Shane" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Shane')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>

<!-- Card 5 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra Fast Delivery. Text me for info. Do not purchase directly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Arthur.png') }}" alt="Arthur" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Arthur')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>

<!-- Card 6 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Kristin.png') }}" alt="Kristin" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Kristin')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>


<!-- Card 7 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Angel.png') }}" alt="Angel" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Angel')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>

<!-- Card 8 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Marjorie.png') }}" alt="Marjorie" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Marjorie')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>


<!-- Card 9 -->
<a href="{{ route('boost.buy-now') }}" wire:navigate>
    <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
        <h3 class="text-lg font-medium mb-3">
            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
        </h3>
        <div class="flex gap-4 text-sm text-text-secondary py-4">
            <span class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/light.png') }}" alt=""> {{ __('Pc') }}
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Pickaxes') }}: 0-10
            </span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                {{ __('Outfits') }}: {{ __('None') }}
            </span>
        </div>
        <div class="border-slate-700 pt-14 flex items-center justify-between py-4">
            <span class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-text-white">$76.28</span>
            <span class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-white">
                <img src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{ __('Instants') }}
            </span>
        </div>
        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
            <img src="{{ asset('assets/images/Soham.png') }}" alt="Soham" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-semibold text-text-white">{{__('Soham')}}</p>
                <p class="text-sm text-text-secondary">
                    <img class="inline mr-2" src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3% |
                    2434 {{ __('reviews') }} | 1642 {{ __('Sold') }}
                </p>
            </div>
        </div>
    </div>
</a>
</div>

<!-- Pagination -->
<div class="flex justify-end items-center space-x-3 p-4 m-10">
    <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Previous') }}</button>

    <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">1</button>
    <button class="text-text-primary text-sm hover:text-purple-500">2</button>
    <button class="text-text-primary text-sm hover:text-purple-500">3</button>
    <button class="text-text-primary text-sm hover:text-purple-500">4</button>
    <button class="text-text-primary text-sm hover:text-purple-500">5</button>

    <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Next') }}</button>
</div>
</div>
        </div>

</section>
