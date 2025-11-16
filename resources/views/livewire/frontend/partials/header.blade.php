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
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('home') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500! hover:border-b-2 hover:border-second-500' }}">
                {{ __('Home') }}
            </a>
            <a href="{{ route('tiktok-mixed-feed') }}" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('tiktok-mixed-feed') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover:border-second-500' }}">
                {{ __('Tiktok') }}
            </a>
            <a href="{{ route('product') }}" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('product') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500 hover:border-b-2 hover:border-second-500' }}">
                {{ __('Products') }}
            </a>
            <a href="{{ route('video-feed') }}" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('video-feed') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500! hover:border-b-2 hover:border-second-500' }}">
                {{ __('Video Feed') }}
            </a>
            <a href="{{ route('blog') }}" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('blog*') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500! hover:border-b-2 hover:border-second-500' }}">
                {{ __('Blog') }}
            </a>
            <a href="{{ route('about') }}" wire:navigate
                class="text-text-muted font-inter transition-colors {{ request()->routeIs('about') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500! hover:border-b-2 hover-border-second-500' }}">
                {{ __('About') }}
            </a>
        </nav>

        <div class="hidden md:block">
            <x-language />
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
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('home') ? 'text-second-500!! underline ' : 'hover:text-second-500!' }}">
                {{ __('Home') }}
            </a>
            <a href="{{ route('product') }}" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('product') ? 'text-second-500!! ' : 'hover:text-second-500!!' }}">
                {{ __('Products') }}
            </a>
            <a href="{{ route('video-feed') }}" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('video-feed') ? 'text-second-500!! ' : 'hover:text-second-500!!' }}">
                {{ __('Video Feed') }}
            </a>
            <a href="{{ route('blog') }}" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('blog') ? 'text-second-500!! ' : 'hover:text-second-500!!' }}">
                {{ __('Blog') }}
            </a>
            <a href="{{ route('about') }}" wire:navigate
                class="text-text-muted font-medium font-inter transition-colors {{ request()->routeIs('about') ? 'text-second-500!! ' : 'hover:text-second-500!!' }}">
                {{ __('About') }}
            </a>
            <x-language />
            {{-- <a href="#" wire:navigate
                class="mt-2 px-6 py-2.5 btn-gradient text-white font-semibold rounded-full text-center">
                {{ __('Discover Glow') }}
            </a> --}}
        </nav>
    </div>
</header>
