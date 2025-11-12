<header x-data="{ mobileMenuOpen: false }" x-cloak class="sticky top-0 z-50 bg-white">
    <div class="container-wide flex items-center justify-between py-3 px-6">
        <!-- Logo Section -->
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
            <div
                class="w-10 lg:w-14 h-10 lg:h-14 xl:w-16 xl:h-16 rounded-full btn-gradient flex items-center justify-center">
                <span class="text-white font-bold text-lg lg:text-2xl xl:text-3xl">{{ __('DG') }}</span>
            </div>
            <span
                class="text-lg lg:text-2xl xl:text-3xl font-bold font-playfair text-text-primary">{{ __('DiodioGlow') }}</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('home') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover:border-second-500' }}">
                {{ __('Home') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('products') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover:border-second-500' }}">
                {{ __('Products') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('video-feed') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover:border-second-500' }}">
                {{ __('Video Feed') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('blog') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover:border-second-500' }}">
                {{ __('Blog') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('about') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover-border-second-500' }}">
                {{ __('About') }}
            </a>
        </nav>

        <!-- CTA Button -->
        <div x-data="{ open: false }" class="relative hidden md:block">
            <button @click="open = !open" wire:navigate
                class="flex items-center gap-1 px-6 py-2.5 btn-gradient text-white font-semibold rounded-full hover:shadow-lg transition-all duration-300">
                {{ __('English') }}

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 transition-transform  duration-200"
                    :class="open ? 'rotate-180' : 'rotate-0'" fill="none" viewBox="0 0 24 24" stroke="white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0  w-36 bg-white border border-gray-200 rounded-xl shadow-lg z-50">
                <ul class="py-2 text-gray-700">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition">
                            English
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 transition">
                            Français
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-text-muted"
            aria-label="{{ __('Toggle menu') }}">
            <flux:icon name="menu" class="w-6 h-6" />
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform -translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2" class="md:hidden border-t border-gray-200 bg-white">
        <nav class="container mx-auto px-6 py-4 flex flex-col gap-4">
            <a href="#" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('home') ? 'text-second-500! underline ' : 'hover:text-second-500' }}">
                {{ __('Home') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('products') ? 'text-second-500! ' : 'hover:text-second-500!' }}">
                {{ __('Products') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('video-feed') ? 'text-second-500! ' : 'hover:text-second-500!' }}">
                {{ __('Video Feed') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('blog') ? 'text-second-500! ' : 'hover:text-second-500!' }}">
                {{ __('Blog') }}
            </a>
            <a href="#" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('about') ? 'text-second-500! ' : 'hover:text-second-500!' }}">
                {{ __('About') }}
            </a>
            <div x-data="{ openLang: false }" class="relative">
                <button @click="openLang = !openLang"
                    class="w-full mt-2 flex items-center justify-between px-5 py-2.5 bg-gray-100 rounded-full font-semibold text-gray-700">
                    {{ __('English') }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform duration-200"
                        :class="openLang ? 'rotate-180' : 'rotate-0'" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openLang" x-transition
                    class="absolute right-0 w-full bg-white border border-gray-200 rounded-xl shadow-lg mt-2 z-50">
                    <ul class="py-2 text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">English</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Français</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" wire:navigate
                class="mt-2 px-6 py-2.5 btn-gradient text-white font-semibold rounded-full text-center">
                {{ __('Discover Glow') }}
            </a>


        </nav>
    </div>
</header>
