<div class="#">
    <div class="lg:w-[1400px] bg-[#0d061a] mx-auto">
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
                            <a href="#" class="navbar_style">{{ __('Accounts') }}</a>
                            <a href="#" class="navbar_style">{{ __('Top Ups') }}</a>
                            <a href="#" class="navbar_style">{{ __('Gift Card') }}</a>
                        </nav>
                    </div>
                </div>
        </div>
        </header>
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-8 py-8">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-8 text-sm">
                <span class="text-blue-100">
                    <img width="25" class="inline-block" src="{{ asset('assets/images/mdb.png') }}" alt="img">
                    {{ __('Blade ball tokens') }}</span>
                <span class="text-slate-100">></span>
                <span class="text-slate-100">{{ __('Seller list') }}</span>
            </div>

            <!-- Filters Section -->
            <div class="mb-8 space-y-4">
                <div class="flex gap-4 flex-wrap">
                    <div class="flex-1 min-w-64">
                        <div class="relative">
                            <input type="text" placeholder="Search"
                                class="w-full bg-slate-900 border border-slate-700 rounded-full px-4 py-2 pl-10 focus:outline-none focus:border-purple-500">
                            <span class="absolute left-3 top-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>{{ __('Device') }}</option>
                    </select>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>{{ __('Account type') }}</option>
                    </select>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>{{ __('Price') }}</option>
                    </select>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>{{ __('Select Delivery Time') }}</option>
                    </select>
                    <button class="text-slate-100 hover:text-white transition">{{ __('Clear all') }}</button>
                </div>

                <!-- Game Tags -->
                <div class="flex gap-2 flex-wrap">
                    <button
                        class="px-3 py-1 bg-slate-800/60 rounded text-sm hover:bg-slate-700 transition">{{ __('Robux') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Steel A Brainrot') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Grow A Garden') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Hunty
                                                                    Zombie') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('99 Nights In The Forest') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('prospecting') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('All Star Tower Defense X') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Ink Game') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Garden Tower Defense') }}</button>
                </div>

                <div class="flex gap-2 flex-wrap">
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Bubble Gum Simulator') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Dead Rails') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('TYPE./ ISOUL') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Hypershot') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Build A Zoo') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Gems') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Rivals') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('MM2') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Blox Fruit') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Pet Simulator 99') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Spin') }}</button>
                    <button
                        class="px-3 py-1 bg-slate-800/40 rounded text-sm hover:bg-slate-700 transition">{{ __('Adopt Me') }}</button>
                </div>

                <!-- Right Filters -->
                <div class="flex gap-3 justify-end">
                    <button
                        class="px-4 py-2 border border-green-500 text-green-500 rounded-full text-sm hover:bg-green-500 hover:text-white transition">{{ __("● Online Seller") }}</button>
                    <select
                        class="bg-slate-900 border border-slate-700 rounded-full px-4 py-2 focus:outline-none focus:border-purple-500">
                        <option>{{ __('Recommended') }}</option>
                    </select>
                </div>
            </div>

            <!-- Product Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Victoria.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Victoria') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra Fast
                                                                    Delivery. Text me for info. Do not purchase directly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Colleen.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Colleen') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get
                                                                    fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Esther.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Esther') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Shane.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Shane') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra Fast Delivery. Text me for info. Do not purchase directly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Arthur.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Arthur') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">Outfits:
                            None</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Kristin.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Kristin') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 7 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{ __('Instants') }}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Angel.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{ __('Angel') }}</p>
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 8 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
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
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 9 -->
                <div class="bg-[#1B0C33] rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">
                        {{ __('Instant EA Sports FC Coins: Build your Ultimate Team now! Get fast, secure, and cheap EA Sports FC Coins instantly.') }}
                    </h3>
                    <div class="flex gap-4 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/light.png') }}" alt="">
                            {{ __('Pc') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Pickaxes: 0-10') }}</span>
                        <span
                            class="flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition">{{ __('Outfits: None') }}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">{{ __('$76.28') }}</span>
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
                            <p class="text-sm text-slate-100 "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">
                                {{ __('99.3% | 2434 reviews | 1642 Sold') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center space-x-3  p-4 m-10">
                <button class="text-white text-sm hover:text-purple-500">{{ __('Previous') }}</button>

                <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">{{ __('1') }}</button>
                <button class="text-white text-sm hover:text-purple-500">{{ __('2') }}</button>
                <button class="text-white text-sm hover:text-purple-500">{{ __('3') }}</button>
                <button class="text-white text-sm hover:text-purple-500">{{ __('4') }}</button>
                <button class="text-white text-sm hover:text-purple-500">{{ __('5') }}</button>

                <button class="text-white text-sm hover:text-purple-500">{{ __('Next') }}
                </button>
            </div>
        </main>
    </div>
</div>
</div>
