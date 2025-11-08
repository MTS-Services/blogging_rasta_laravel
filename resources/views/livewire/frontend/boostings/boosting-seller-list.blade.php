<div>
    <div class="container ">
        <div class="  text-white">
            <!-- Header -->
            <header class=" sm:py-4 sm:px-8 lg:py-0 lg:px-0">
                <div class=" text-white px-18 lg:px-0 md:px-0">
                    <div
                        class="max-w-[900px] mx-auto flex flex-col md:flex-row gap-4 md:items-center justify-between w-full sm:px-6 sm:py-6 lg:py-0 lg:px-0 mt-4">
                        <!-- Logo -->
                        <div class="flex gap-8">
                            <div class="h-8 w-8 bg-orange-500 rounded flex items-center justify-center font-medium">
                                <img src="{{ asset('assets/images/fortnite.png') }}" alt="">
                            </div>
                            <span class="text-xl font-medium">{{ __('Fortnite') }}</span>
                        </div>
                        <!-- Navigation Links -->
                        <nav
                            class=" peer-checked:flex flex-col lg:flex lg:flex-row gap-6 w-full lg:w-auto  lg:bg-transparent border-t border-gray-800 lg:border-none z-50">
                            <a href="#" class="navbar_style active">{{ __('Items') }}</a>
                            <a href="#" class="navbar_style text-text-primary">{{ __('Accounts') }}</a>
                            <a href="#" class="navbar_style text-text-primary">{{ __('Top Ups') }}</a>
                            <a href="#" class="navbar_style text-text-primary">{{ __('Gift Card') }}</a>
                        </nav>
                    </div>
                </div>
        </div>
        </header>
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-8 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-8 text-sm">
                <span class="text-blue-100 text-text-primary">
                    <img width="25" class="inline-block" src="{{ asset('assets/images/mdb.png') }}" alt="img">
                    {{ __('Blade ball tokens') }}</span>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">{{ __('Seller list') }}</span>
            </div>

            <!-- Filters Section -->
            <div class="mb-8 space-y-4">
                <div class="flex gap-4 flex-wrap">
                    <div class="flex-1 min-w-64">
                        <div class="relative">
                            <input type="text" placeholder="Search"
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
                    <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                        <option value="">{{ __('Device') }}</option>
                    </x-ui.select>
                    <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                        <option value="">{{ __('Account type') }}</option>
                    </x-ui.select>
                    <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                        <option value="">{{ __('Price') }}</option>
                    </x-ui.select>
                    <x-ui.select id="status-select" class="py-0.5! w-auto! rounded-full!">
                        <option value="">{{ __('Select Delivery Time') }}</option>
                    </x-ui.select>
                    <button class="text-text-primary hover:text-white transition">{{ __('Clear all') }}</button>
                </div>

                <!-- Game Tags -->
                <div class="flex gap-2 flex-wrap">
                    <button
                        class="px-3 py-1 bg-slate-800/60 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Robux') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Steel
                                                                        A
                                                                        Brainrot') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Grow
                                                                        A
                                                                        Garden') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Hunty
                                                                        Zombie') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('99
                                                                        Nights In
                                                                        The Forest') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('prospecting') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('All
                                                                        Star
                                                                        Tower
                                                                        Defense X') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Ink
                                                                        Game') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Garden
                                                                        Tower
                                                                        Defense') }}</button>
                </div>

                <div class="flex gap-2 flex-wrap">
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Bubble
                                                                        Gum
                                                                        Simulator') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Dead
                                                                        Rails') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('TYPE./
                                                                        ISOUL') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Minecraft') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Build
                                                                        A
                                                                        Zoo') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Gems') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Rivals') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('MM2') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Blox
                                                                        Fruit') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Pet
                                                                        Simulator
                                                                        99') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Spin') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-500 transition text-white">{{ __('Adopt
                                                                        Me') }}</button>
                </div>

                <!-- Right Filters -->
                <div class="flex gap-3 justify-end">
                    <button
                        class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">{{ __('●
                                                                        Online Seller') }}</button>

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
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-1 text-sm text-text-secondary py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1  text-white text-text-white bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-text-secondary "><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1  text-white text-text-white bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition  ">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition   text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF]   px-4 py-2 rounded-full font-bold  text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class=" flex items-center gap-2 px-3 py-1 bg-slate-800/60 text-text-secondary rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Victoria.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold text-text-white">{{ 'Victoria' }}</p>
                                <p class="text-sm text-text-secondary "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3% |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra Fast Delivery. Text me for info. Do not purchase directly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white "><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-1 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-white text-text-white flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Colleen.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Colleen') }}</p>
                                <p class="text-sm text-text-secondary"> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Esther.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Esther') }}</p>
                                <p class="text-sm text-text-secondary "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Shane.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Shane') }}</p>
                                <p class="text-sm text-text-secondary"> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 5 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra
                                                                                    Fast
                                                                                    Delivery. Text me for info. Do not purchase directly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div
                            class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3 text-white text-text-white">
                            <img src="{{ asset('assets/images/Arthur.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Arthur') }}</p>
                                <p class="text-sm text-text-secondary "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 6 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Kristin.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Instants') }}</p>
                                <p class="text-sm text-text-secondary "> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 7 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Angel.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Angel') }}</p>
                                <p class="text-sm text-text-secondary"> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 8 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ __('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Marjorie.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Marjorie') }}</p>
                                <p class="text-sm text-text-secondary"> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 9 -->
                <a href="{{ route('boost.buy-now') }}" wire:navigate>
                    <div
                        class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-400 transition">
                        <h3 class="text-lg font-medium mb-3">
                            {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now!
                                                                                    Get
                                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                        </h3>
                        <div class="flex gap-4 text-sm text-slate-400 py-4">
                            <span
                                class="flex items-center gap-1 px-2 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white"><img
                                    src="{{ asset('assets/images/light.png') }}" alt="">
                                {{ _('Pc') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Pickaxes:
                                                                                                0-10') }}</span>
                            <span
                                class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white text-text-white">{{ __('Outfits:
                                                                                                None') }}</span>
                        </div>
                        <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                            <span
                                class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold text-white text-text-white">{{ __('$76.28') }}</span>
                            <span
                                class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                    src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                                {{ __('Instants') }}</span>
                        </div>
                        <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                            <img src="{{ asset('assets/images/Soham.png') }}" alt="Esther"
                                class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-semibold ">{{ __('Soham') }}</p>
                                <p class="text-sm text-text-secondary"> <img class="inline mr-2"
                                        src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                    {{ __('99.3%
                                                                                                            |
                                                                                                            2434 reviews | 1642 Sold') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="flex justify-end items-center space-x-3  p-4 m-10">
                <button class="text-text-primary text-sm hover:text-purple-500">{{ __('Previous') }}</button>

                <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">{{ __('1') }}</button>
                <button class="text-text-primary text-sm hover:text-purple-500">{{ __('2') }}</button>
                <button class="text-text-primary text-sm hover:text-purple-500">{{ __('3') }}</button>
                <button class="text-text-primary text-sm hover:text-purple-500">{{ __('4') }}</button>
                <button class="text-text-primary text-sm hover:text-purple-500">{{ __('5') }}</button>

                <button class="text-text-primary text-sm hover:text-purple-500">{{__('Next')}}</button>
            </div>
        </main>
    </div>
</div>
