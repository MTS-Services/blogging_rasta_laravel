<header x-data="{ mobileMenuOpen: false }" x-cloak class="sticky top-0 z-50 bg-white">
    <div class="container-wide flex items-center justify-between py-3 px-6">
        <!-- Logo Section -->
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
            <div class="w-10 lg:w-14 h-10 lg:h-14 xl:w-16 xl:h-16 rounded-full bg-linear-to-br from-second-500! to-zinc-500! flex items-center justify-center">
                <span class="text-white font-bold text-lg lg:text-2xl xl:text-3xl">DG</span>
            </div>
            <span class="text-lg lg:text-2xl xl:text-3xl font-bold font-playfair text-text-primary">DiodioGlow</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}" wire:navigate
                class="text-text-muted  font-inter transition-colors {{ request()->routeIs('home') ? 'text-second-500! border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Home
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary  font-inter transition-colors {{ request()->routeIs('products') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Products
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary  font-inter transition-colors {{ request()->routeIs('video-feed') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Video Feed
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary  font-inter transition-colors {{ request()->routeIs('blog') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Blog
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary  font-inter transition-colors {{ request()->routeIs('about') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                About
            </a>
        </nav>

        <!-- CTA Button -->
        <div class="hidden md:block">
            <a href="#" wire:navigate
                class="px-6 py-2.5 bg-linear-to-r from-second-500 to-zinc-500 text-white font-semibold rounded-full hover:shadow-lg transition-all duration-300">
                Discover Glow
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-text-secondary">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
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
                class="text-text-secondary font-medium font-inter transition-colors {{ request()->routeIs('home') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Home
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary font-medium font-inter transition-colors {{ request()->routeIs('products') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Products
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary font-medium font-inter transition-colors {{ request()->routeIs('video-feed') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Video Feed
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary font-medium font-inter transition-colors {{ request()->routeIs('blog') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                Blog
            </a>
            <a href="#" wire:navigate
                class="text-text-secondary font-medium font-inter transition-colors {{ request()->routeIs('about') ? 'text-second-500 border-b-2 border-second-500' : 'hover:text-second-500' }}">
                About
            </a>
            <a href="#" wire:navigate
                class="mt-2 px-6 py-2.5 bg-gradient-to-r from-[#FB7382] to-[#FBBA2A] text-white font-semibold rounded-full text-center">
                Discover Glow
            </a>
        </nav>
    </div>
</header>
