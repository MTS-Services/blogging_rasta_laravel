<header
    class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 z-10 {{ request()->routeIs('home') ? 'bg-linear-to-r from-zinc-950 via-black to-zinc-950' : 'glass-card' }}">
    <div class="flex items-center justify-between">
        <!-- Logo and Mobile Menu -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile Menu Toggle -->
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-text-white hover:text-zinc-300">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ route('home') }}" wire:navigate>
                <img src="{{ asset('assets/images/header_logo.png') }}" alt="Logo" class="h-6 sm:h-8 w-auto">
            </a>
        </div>

        <!-- Desktop Navigation -->
        @include('partials.user-navigation')

        <!-- Right Side Icons -->
        <div class="flex items-center gap-1 sm:gap-2">
            <!-- Mobile Search -->
            <button class="lg:hidden text-text-white hover:bg-zinc-800 p-1.5 sm:p-2 rounded transition-all">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            <!-- Messages -->
            <button class="text-text-white p-1 sm:p-1.5 rounded transition-all">
                <flux:icon name="chat-bubble-oval-left" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white" />
            </button>

            <!-- Theme Toggle -->
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun" />
                <flux:radio value="dark" icon="moon" />
            </flux:radio.group>

            <!-- Notifications -->
            <button class="text-text-white hover:bg-zinc-800 p-1 sm:p-1.5 md:p-2 rounded transition-all relative">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-text-btn-primary" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span
                    class="absolute -top-1 -right-1 bg-linear-to-r from-pink-500 to-red-500 text-text-white text-xs font-bold px-1 sm:px-1.5 py-0.5 rounded-full min-w-[18px] sm:min-w-[20px] text-center">1</span>
            </button>

            <!-- User Profile Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="flex items-center p-1 sm:p-1.5 rounded-lg text-text-white transition-all focus:outline-none">
                    <div class="w-7 h-7 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full shadow-lg overflow-hidden">
                        <img src="{{ storage_url(auth()->user()->avatar) }}" class="w-full h-full object-cover"
                            alt="{{ auth()->user()->full_name ?? 'User Avatar' }}">
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" x-cloak @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute right-0 mt-2 w-56 sm:w-64 bg-bg-primary  rounded-xl shadow-2xl overflow-hidden z-50">

                    <!-- User Info Header -->
                    <div class="px-4 py-5 shadow-lg bg-bg-secondary">
                        <p class="text-sm font-semibold text-text-white truncate">
                            {{ auth()->user()->full_name }}
                        </p>
                        <p class="text-xs text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="flex-1 px-3 py-4 space-y-2">
                        <!-- Orders Dropdown -->
                        <div x-data="{
                            ordersOpen: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }},
                            isActive: {{ in_array($pageSlug, ['purchased_orders', 'sold_orders']) ? 'true' : 'false' }}
                        }">
                            <!-- Orders button -->
                            <button x-cloak @click="ordersOpen = !ordersOpen"
                                :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                                class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <flux:icon name="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6 text-text-white" />
                                    <span class="text-xs  font-medium text-text-white">{{ __('Orders') }}</span>

                                    <!-- Left indicator bar -->
                                    <div x-show="isActive" x-cloak
                                        class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-linear-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                                    </div>
                                </div>

                                <!-- Chevron Icons -->
                                <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                            </button>

                            <!-- Dropdown links -->
                            <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                                <a href="{{ route('user.purchased-orders') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'purchased_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Purchased orders') }}
                                </a>
                                <a href="{{ route('user.sold-orders') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'sold_orders' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Sold orders') }}
                                </a>
                            </div>
                        </div>
                        <!-- Offers Dropdown -->
                        <div x-data="{
                            ordersOpen: {{ in_array($pageSlug, ['currency', 'accounts', 'top-ups', 'items', 'gift-cards']) ? 'true' : 'false' }},
                            isActive: {{ in_array($pageSlug, ['currency', 'accounts', 'top-ups', 'items', 'gift-cards']) ? 'true' : 'false' }}
                        }">
                            <!-- Offers button -->
                            <button x-cloak @click="ordersOpen = !ordersOpen"
                                :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                                class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <x-phosphor-tag class="w-5 h-5 rotate-90 fill-text-text-white" />
                                    <span class="text-xs  font-medium text-text-white">{{__('Offers')}}</span>

                                    <!-- Left indicator bar -->
                                    <div x-show="isActive" x-cloak
                                        class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                                    </div>
                                </div>

                                <!-- Chevron Icons -->
                                <flux:icon name="chevron-down" x-show="!ordersOpen" x-cloak
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                <flux:icon name="chevron-up" x-show="ordersOpen" x-cloak
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                            </button>

                            <!-- Dropdown links -->
                            <div x-show="ordersOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                                <a href="{{ route('user.currency') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'currency' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Currency') }}
                                </a>
                                <a href="{{ route('user.accounts') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'accounts' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Accounts') }}
                                </a>
                                <a href="{{ route('user.top-ups') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'top-ups' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Top Ups') }}
                                </a>
                                <a href="{{ route('user.items') }}" wire:navigate @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'items' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Items') }}
                                </a>
                                <a href="{{ route('user.gift-cards') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'gift-cards' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Gift Cards') }}
                                </a>
                            </div>
                        </div>
                        <!-- Boosting Link -->
                        <div x-data="{
                            boostingOpen: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }},
                            isActive: {{ in_array($pageSlug, ['my-requests', 'received-requests']) ? 'true' : 'false' }}
                        }">
                            <!-- Boosting button -->
                            <button x-cloak @click="boostingOpen = !boostingOpen"
                                :class="isActive ? 'bg-pink-300 dark:bg-zinc-950 relative' : 'bg-pink-400 dark:bg-zinc-950'"
                                class="w-full flex items-center justify-between px-2 sm:px-3 py-2.5 sm:py-3 rounded-lg transition-all text-text-white hover:bg-pink-500/50">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <x-phosphor name="circles-four" variant="solid"
                                        class="w-5 h-5 rotate-90 fill-text-text-white" />
                                    <span class="text-xs  font-medium text-text-white">{{__('Boosting')}}</span>

                                    <!-- Left indicator bar -->
                                    <div x-show="isActive" x-cloak
                                        class="absolute left-0 top-0 w-1.5 sm:w-2 h-full bg-gradient-to-b from-pink-500 to-zinc-600 rounded-l-full z-50">
                                    </div>
                                </div>

                                <!-- Chevron Icons -->
                                <flux:icon name="chevron-down" x-show="!boostingOpen" x-cloak
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                                <flux:icon name="chevron-up" x-show="boostingOpen" x-cloak
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform text-text-white" />
                            </button>

                            <!-- Dropdown links -->
                            <div x-show="boostingOpen" x-collapse x-cloak class="mt-1 ml-6 sm:ml-8 space-y-1">
                                <a href="{{ route('user.my-requests') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'my-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('My Requests') }}
                                </a>
                                <a href="{{ route('user.received-requests') }}" wire:navigate
                                    @click="$root.sidebarOpen = false"
                                    class="block px-2 sm:px-3 py-2 text-xs  rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'received-requests' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                                    {{ __('Received Requests') }}
                                </a>
                            </div>
                        </div>
                        <!-- Loyalty Link -->
                        <a href="{{ route('user.loyalty') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'loyalty' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <flux:icon name="trophy" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                            <span class="text-xs  font-medium text-text-white">{{ __('Loyalty') }}</span>
                        </a>
                        <!-- Wallet Link -->
                        <a href="{{ route('user.wallet') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'wallet' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <x-phosphor name="cardholder" variant="regular"
                                class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                            <span class="text-xs  font-medium text-text-white">{{ __('Wallet') }}</span>
                        </a>
                        <!-- messages Link -->
                        <a href="{{ route('user.messages') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'messages' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <flux:icon name="chat-bubble-bottom-center-text"
                                class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                            <span class="text-xs  font-medium text-text-white">{{ __('Messages') }}</span>
                        </a>
                        <!-- Feedback Link -->
                        <a href="{{ route('user.feedback') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'feedback' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <flux:icon name="star" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                            <span class="text-xs  font-medium text-text-white">{{ __('Feedback') }}</span>
                        </a>
                        {{-- settings --}}
                        <a href="{{ route('user.account-settings') }}" wire:navigate
                            @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'account-settings' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <x-phosphor name="gear" class="w-4 h-4 sm:w-5 sm:h-5 fill-text-text-white" />
                            <span class="text-xs  font-medium text-text-white">{{ __('Account Settings') }}</span>
                        </a>
                        <!-- View Profile Link -->
                        {{-- <a href="{{ route('user.profile') }}" wire:navigate @click="$root.sidebarOpen = false"
                            class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-2 rounded-lg transition-all text-text-white hover:bg-pink-500/50 {{ $pageSlug === 'profile' ? 'bg-pink-500' : 'bg-pink-300 dark:bg-zinc-950' }}">
                            <flux:icon name="user" class="w-4 h-4 sm:w-5 sm:h-5 text-text-white" />
                            <span
                                class="text-xs  font-medium text-text-white">{{ __('View Profile') }}</span>
                        </a> --}}
                        <div class="my-2 px-2">
                            <div class="border-t border-zinc-800"></div>
                        </div>
                        <!-- Profile & Logout -->
                        <div class="space-y-1">
                            <a href="{{ route('user.profile') }}" wire:navigate @click="open = false"
                                class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all {{ $pageSlug === 'profile' ? 'bg-zinc-800 text-white' : 'text-zinc-300 hover:text-white hover:bg-zinc-800/50' }}">
                                <flux:icon name="user" class="w-4 h-4" />
                                <span>{{__('View Profile')}}</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-all">
                                    <flux:icon name="arrow-right-start-on-rectangle" class="w-4 h-4" />
                                    <span>{{__('Logout')}}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <nav class="lg:hidden mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-zinc-800 flex flex-wrap gap-2 sm:gap-3">
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Currency')}}</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Gift
            Cards')}}</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Boosting')}}</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Items')}}</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Accounts')}}</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Top
            Ups')}}</a>
        <a href="#"
            class="text-text-white text-xs font-medium hover:text-purple-400 transition-colors whitespace-nowrap">{{__('Coaching')}}</a>
    </nav>
</header>
