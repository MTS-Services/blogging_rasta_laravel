<section>
    <div class="max-w-7xl mx-auto px-8 py-8">
        <!-- Breadcrumb -->
        <a href="{{ route('game.index', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug]) }}">
            <div class="group flex items-center gap-2 my-8 text-lg font-semibold">
                <span class="text-text-primary group-hover:text-pink-400 transition-colors duration-300">
                    < </span>
                        <h1 class="text-text-white group-hover:text-pink-400 transition-colors duration-300">
                            {{ __('All Offers') }}
                        </h1>
            </div>

        </a>

        {{-- <div class="flex items-center gap-2 mb-8 text-md font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <h1 class="text-text-white">
                {{ ucwords(str_replace('-', ' ', $gameSlug)) . ' ' . ucwords(str_replace('-', ' ', $categorySlug)) }}
            </h1>

            <span class=" text-text-primary">></span>
            <span class=" text-text-primary">Buy Now</span>
        </div> --}}
        <div>

            <div class=" text-white min-h-screen">
                <div class="w-full mx-auto">
                    <!-- Main Content Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Left Column - Product Details -->
                        <div class="lg:col-span-2">
                            <!-- Seller Info -->
                            <div class="bg-bg-primary  rounded-lg p-6 mb-6">
                                <div class="flex items-center gap-4 mb-6">
                                    <img src="{{ asset('assets/images/Devon Lane.png') }}" alt="Devon Lane"
                                        class="w-16 h-16 rounded-full border-2 border-purple-500">
                                    <div>
                                        <h2 class="text-xl font-bold">{{__('Devon Lane')}}</h2>
                                        <div class="flex items-center gap-2 text-sm text-gray-300">
                                            <span class="text-purple-400 flex items-center ">
                                                <img class="px-2" src="{{ asset('assets/images/Subtract.png') }}"
                                                    alt="">
                                                99.3%</span>
                                            <span>{{__('2434 reviews')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="border-t border-b border-purple-500/60 pt-4 mb-4">
                                    <div
                                        class="flex justify-between items-center py-3">
                                        <span
                                            class="text-text-primary sm:text-2xl md:text-3xl lg:text-4xl">{{ __('Delivery time') }}
                                            </span>
                                        <span
                                            class="text-gray-100 sm:text-sm md:text-md lg:text-lg">{{ __('15min') }}</span>
                                        </div>
                                </div>

                                <!-- Warning -->
                                <div class="    rounded p-4 mb-6">
                                    <p class=" sm:text-sm md:text-md lg:text-lg">{{__('READ BEFORE PURCHASE ! (ONLY
                                        GAMEPASS) 30% Tax IS NOT
                                        COVERED')}}</p>
                                </div>

                                <!-- Product Title -->
                                <h1 class="sm:text-1xl md:text-2xl lg:text-3xl mb-6">{{__('EA SPORTS FC COINS')}}</h1>

                                <!-- How to Purchase -->
                                <div class="mb-6">
                                    <h3 class=" sm:text-sm md:text-md lg:text-lg mb-3">{{__('How to purchase')}}</h3>
                                    <ol class="space-y-2 text-lg text-gray-300">
                                        <li><span class="font-semibold">1.</span>{{__('Select the amount of you want.')}}
                                        </li>
                                        <li><span class="font-semibold">2.</span>{{__('Make a gamepass and send us the
                                            link.')}}</li>
                                        <li><span class="font-semibold">3.</span>{{__('Robuxwill be Pending for 3-7
                                            days')}}</li>
                                    </ol>
                                </div>

                                <!-- Terms -->
                                <div class="space-y-4 text-lg text-gray-400">
                                    <p>{{__('(By purchasing you agree to the following terms) No refunds after
                                        purchasing a game pass
                                        We are not responsible for account bans. No refund, no after-sales
                                        service. rmt violates
                                        the game')}}</p>
                                    <p>{{__('(By purchasing you agree to the following terms) No refunds after
                                        purchasing a game pass
                                        We are not responsible for account bans. No refund, no after-sales
                                        service. rmt violates
                                        the game')}}</p>
                                </div>
                            </div>

                            <!-- Other Sellers -->
                            <div class="mt-6 ">
                                <h2 class="text-2xl font-bold mb-6">{{__('Other sellers (84)')}}</h2>
                                <div class=" rounded-full p-4 ">
                                    <button
                                        class="flex items-center justify-between  px-6 py-3 border border-purple-500/50 rounded-full hover:bg-purple-900/20 transition">
                                        <span>{{__('Recommended')}}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6 ml-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Pricing & Checkout -->
                        <div class="lg:col-span-1">
                            <!-- Price Section -->
                            <div class="bg-bg-primary rounded-lg p-6 mb-6 ">
                                <div class="mb-3 flex items-center justify-between border-b border-zinc-500">
                                    <p class="text-text-primary text-sm mb-2">{{__('Price')}}</p>
                                    <p class="text-3xl ">$76.28<span class="text-lg text-text-primary">{{__('/unit')}}</span>
                                    </p>
                                </div>
                                {{-- order incriment decriment --}}
                                <div class="p-4 rounded-lg max-w-xl mx-auto">
                                    <div class="flex items-center gap-4">
                                        <x-ui.button class="w-auto! py-1! px-3!" onclick="decreaseQuantity()">
                                            &minus;
                                        </x-ui.button>

                                        <x-ui.input type="number" id="quantity" name="quantity" class="text-center"
                                            value="300" readonly />

                                        <x-ui.button class="w-auto! py-1! px-3!" onclick="increaseQuantity()">
                                            +
                                        </x-ui.button>
                                    </div>

                                    <div class="flex justify-between mt-3 text-xs text-gray-400">
                                        <span>{{__('Minimum Quantity: 1000 unit')}}</span>
                                        <span>{{__('In Stock: 57000 unit')}}</span>
                                    </div>
                                </div>
                                <!-- Buy Button -->
                                <a href="{{ route('game.checkout', ['orderId' => 12345]) }}" wire:navigate
                                    class="block text-center w-full bg-gradient-to-r bg-[#853EFF]  text-gray-100 sm:text-sm md:text-md lg:text-lg py-3 px-4 rounded-full mb-6 transition transform hover:scale-105">
                                   {{__(' $76.28 | Buy now')}}
                                </a>

                                <!-- Guarantees -->
                                <div class="space-y-4">
                                    <!-- Money-back -->
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-sm">{{__('Money-back Guarantee')}}</p>
                                            <p class="text-xs text-gray-400">{{__('Protected by TradeShield')}}</p>
                                        </div>
                                    </div>

                                    <!-- Fast Checkout -->
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z">
                                            </path>
                                        </svg>
                                        <div class="flex">
                                            <p class="font-semibold text-sm">{{__('Fast Checkout Options')}}</p>
                                            <div class="flex gap-0 ">
                                                <span class="text-xs   px-2 rounded">
                                                    <img src="{{ asset('assets/images/GooglePay-Light 1.svg') }}"
                                                        alt="">
                                                </span>
                                                <span class="text-xs   px-2  rounded"> <img
                                                        src="{{ asset('assets/images/ApplePay-Light 1.svg') }}"
                                                        alt="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Support -->
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-purple-400 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                            </path>
                                        </svg>
                                        <div>
                                            <p class="font-semibold text-sm">{{__('24/7 Live Support')}}</p>
                                            <p class="text-xs text-gray-400">{{__('We\'re always here to help')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Instructions -->
                            <div class="bg-bg-primary rounded-lg  mb-6 px-4 py-4 ">
                                <h3 class="font-bold mb-4">{{__('Delivery Instructions')}}</h3>
                                <div class="flex gap-4 mb-4">
                                    <button class="text-sm text-purple-400 hover:text-purple-300">{{__('Welcome')}}</button>
                                    <button class="text-sm text-gray-400 hover:text-gray-300">{{__('Why choose
                                        us')}}</button>
                                </div>
                                <ol class="space-y-2 text-sm text-gray-300">
                                    <li><span class="font-semibold">1.</span> {{__('V-BUCKS are safe to hold and
                                        guaranteed!')}}</li>
                                    <li><span class="font-semibold">2.</span> {{__('Fast replies and delivery.')}}</li>
                                </ol>
                                <button
                                    class="text-purple-400 hover:text-purple-300 text-sm mt-4 mb-4 font-semibold">{{__('See
                                    all')}}</button>
                                <!-- Seller Card -->
                                <div class="bg-bg-primary  p-4 border-t border-purple-800 ">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/Soham (2).png') }}" alt="Soham"
                                            class="w-12 h-12 rounded-full border-2 border-purple-500">
                                        <div class="flex-1">
                                            <p class="font-bold">{{__('Soham')}}</p>
                                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                                <span class="text-purple-400">99.3%</span>
                                                <span>2434 reviews</span>
                                                <span>1642 Sold</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
            <!-- Card 1 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                wire:navigate>
                <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">{{__('Instant EA Sports FC Coins: Build your Ultimate Team now!
                        Get
                        fast, secure, and cheap EA Sports FC Coins instantly.')}}</h3>
                    <div class="flex gap-2 text-sm text-slate-400 py-2">
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white"><img
                                src="{{ asset('assets/images/light.png') }}" alt=""> {{__('Pc')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Pickaxes:
                            0-10')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Outfits:
                            None')}}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img"> {{__('Instants')}}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Victoria.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{__('Victoria')}}</p>
                            <p class="text-sm text-text-primary "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt="">{{__(' 99.3%
                                |
                                2434 reviews | 1642 Sold')}}</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                wire:navigate>
                <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">{{__('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra
                        Fast
                        Delivery. Text me for info. Do not purchase directly.')}}</h3>
                    <div class="flex gap-2 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white"><img
                                src="{{ asset('assets/images/light.png') }}" alt=""> {{__('Pc')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Pickaxes:
                            0-10')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">Outfits:
                            None</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{__('Instants')}}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Colleen.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{__('Colleen')}}</p>
                            <p class="text-sm text-text-primary "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> {{__('99.3%
                                |
                                2434 reviews | 1642 Sold')}}</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                wire:navigate>
                <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">{{__('Instant EA Sports FC Coins: Build your Ultimate Team now!
                        Get
                        fast, secure, and cheap EA Sports FC Coins instantly.')}}</h3>
                    <div class="flex gap-2 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white"><img
                                src="{{ asset('assets/images/light.png') }}" alt=""> {{__('Pc')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Pickaxes:
                            0-10')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Outfits:
                            None')}}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{__('Instants')}}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Esther.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{__('Esther')}}</p>
                            <p class="text-sm text-text-primary "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> {{__('99.3%
                                |
                                2434 reviews | 1642 Sold')}}</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                wire:navigate>
                <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">{{__('Instant EA Sports FC Coins: Build your Ultimate Team now!
                        Get
                        fast, secure, and cheap EA Sports FC Coins instantly.')}}</h3>
                    <div class="flex gap-2 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white"><img
                                src="{{ asset('assets/images/light.png') }}" alt=""> {{__('Pc')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Pickaxes:
                            0-10')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Outfits:
                            None')}}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            Instants</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Shane.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">Shane</p>
                            <p class="text-sm text-text-primary "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> 99.3%
                                |
                                2434 reviews | 1642 Sold</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 5 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                wire:navigate>
                <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">{{__('Custom Offer! 2,000 Trophies, Prestige, 100K Push. Ultra
                        Fast
                        Delivery. Text me for info. Do not purchase directly.')}}</h3>
                    <div class="flex gap-2 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white"><img
                                src="{{ asset('assets/images/light.png') }}" alt=""> {{__('Pc')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Pickaxes:
                            0-10')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Outfits:
                            None')}}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span class="bg-[#853EFF] text-white px-4 py-2 rounded-full font-bold">$76.28</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{__('Instants')}}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Arthur.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{__('Arthur')}}</p>
                            <p class="text-sm text-text-primary "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> {{__('99.3%
                                |
                                2434 reviews | 1642 Sold')}}</p>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 6 -->
            <a href="{{ route('game.buy', ['gameSlug' => $gameSlug, 'categorySlug' => $categorySlug, 'sellerSlug' => 'seller-1']) }}"
                wire:navigate>
                <div class="bg-bg-primary rounded-lg p-8 border border-slate-800 hover:border-purple-500 transition">
                    <h3 class="text-lg font-medium mb-3">{{__('Instant EA Sports FC Coins: Build your Ultimate Team now!
                        Get
                        fast, secure, and cheap EA Sports FC Coins instantly.')}}</h3>
                    <div class="flex gap-2 text-sm text-slate-400 py-4">
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition   text-white">
                            <img src="{{ asset('assets/images/light.png') }}" alt=""> {{__('Pc')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition  text-white">{{__('Pickaxes:
                            0-10')}}</span>
                        <span
                            class="flex items-center gap-1 px-1 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition text-white">{{__('Outfits:
                            None')}}</span>
                    </div>
                    <div class="border-slate-700 pt-14 flex items-center justify-between py-4 ">
                        <span
                            class="bg-[#853EFF] text-text-primary px-4 py-2 rounded-full font-bold text-white">$76.28</span>
                        <span
                            class="text-slate-100 flex items-center gap-2 px-3 py-1 bg-slate-800/60 rounded-full text-sm hover:bg-slate-700 transition"><img
                                src="{{ asset('assets/images/Time Circle.png') }}" alt="img">
                            {{__('Instants')}}</span>
                    </div>
                    <div class="border-t border-[#853EFF] pt-4 mt-4 flex items-center gap-3">
                        <img src="{{ asset('assets/images/Kristin.png') }}" alt="Esther"
                            class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-semibold ">{{__('Kristin')}}</p>
                            <p class="text-sm text-text-primary "> <img class="inline mr-2"
                                    src="{{ asset('assets/images/thumb up filled.png') }}" alt=""> {{__('99.3%
                                |
                                2434 reviews | 1642 Sold')}}</p>
                        </div>
                    </div>
                </div>
            </a>


        </div>
        <div class="flex justify-end items-center space-x-3  p-4 m-10">
            <button class="text-text-primary text-sm hover:text-purple-500">{{__('Previous')}}</button>

            <button class="bg-purple-600 text-white text-sm px-3 py-1 rounded">1</button>
            <button class="text-text-primary text-sm hover:text-purple-500">2</button>
            <button class="text-text-primary text-sm hover:text-purple-500">3</button>
            <button class="text-text-primary text-sm hover:text-purple-500">4</button>
            <button class="text-text-primary text-sm hover:text-purple-500">5</button>

            <button class="text-text-primary text-sm hover:text-purple-500">{{__('Next')}}</button>
        </div>
    </div>

    @push('scripts')
        <script>
            function decreaseQuantity() {
                const input = document.getElementById('quantity');
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                }
            }

            function increaseQuantity() {
                const input = document.getElementById('quantity');
                let value = parseInt(input.value);
                input.value = value + 1;
            }
        </script>
    @endpush
</section>
