<div>
    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="Meilleurs Produits de Beauté & Soins | DiodioGlow Shop">
        <meta name="description"
            content="Explorez notre sélection de produits de beauté viraux et soins pour la peau. Achetez les essentiels skincare recommandés par les influenceuses sénégalaises.">
        <meta name="keywords" content="Produits de beauté Sénégal, Soins visage, Achat cosmétiques, Tendance skincare">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="Meilleurs Produits de Beauté & Soins | DiodioGlow Shop">
        <meta property="og:description"
            content="Explorez notre sélection de produits de beauté viraux et soins pour la peau. Achetez les essentiels skincare recommandés par les influenceuses sénégalaises.">
        <meta property="og:image" content="{{ site_logo() }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="{{ site_logo() }}">
        <link rel="image_src" href="{{ site_logo() }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Meilleurs Produits de Beauté & Soins | DiodioGlow Shop">
        <meta name="twitter:description"
            content="Explorez notre sélection de produits de beauté viraux et soins pour la peau. Achetez les essentiels skincare recommandés par les influenceuses sénégalaises.">
        <meta name="twitter:image" content="{{ site_logo() }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection
    {{-- Product Section --}}
    <div class="container py-24">
        <h1 class="text-text-primary text-5xl font-bold font-montserrat">{{ __('Curated Products') }}</h1>
        <h2 class="text-base text-muted font-semibold font-inter mt-4">
            {{ __('All products handpicked by Diodio Glow • Shop from trusted affiliate stores') }}
        </h2>

        {{-- Category Filter --}}
        <div>

            <div class="flex py-5 xl:py-8 max-w-2xl">
                <div class="relative w-48" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full px-4 py-2 rounded-lg font-inter text-sm font-medium transition-colors bg-second-500 text-white flex items-center justify-between">
                        <span class="text-white">
                            @if ($selectedCategory === 'All')
                                {{ __('All Categories') }}
                            @else
                                {{ $categories->firstWhere('id', $selectedCategory)?->title ?? __('All Categories') }}
                            @endif
                        </span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                            stroke="#fff" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-10 mt-2 w-full rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 max-h-64 overflow-y-auto overflow-x-hidden">
                        <div class="py-1">
                            <!-- All Option -->
                            <button wire:click="selectCategory('All')" @click="open = false"
                                class="w-full text-left block px-4 py-2 text-sm transition-colors {{ $selectedCategory === 'All' ? 'bg-second-500 text-white' : 'text-gray-700 hover:bg-second-500 hover:text-white' }}">
                                {{ __('All Categories') }}
                            </button>

                            <!-- Dynamic Categories -->
                            @foreach ($categories as $category)
                                <button wire:click="selectCategory({{ $category->id }})" @click="open = false"
                                    class="w-full text-left block px-4 py-2 text-sm transition-colors {{ $selectedCategory == $category->id ? 'bg-second-500 text-white' : 'text-gray-700 hover:bg-second-500 hover:text-white' }}">
                                    {{ $category->title }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Cards with Loading State --}}
        <div wire:loading.class="opacity-50 pointer-events-none" wire:target="selectCategory">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @forelse ($products as $product)
                    <div class="group w-full p-6 border border-zinc-300/40 rounded-2xl">
                        {{-- Thumbnail --}}
                        <div class="relative w-full h-[300px] overflow-hidden rounded-2xl">
                            <img src="{{ storage_url($product->image) }}" alt="{{ $product->title }}"
                                title="{{ $product->title }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        <div class="mt-2">
                            <p class="text-xs text-text-primary font-normal font-outfit">
                                {{ $product->category->title }}
                            </p>
                            <h4 class="text-xl font-lato font-medium text-text-primary">
                                {{ $product->title }}
                            </h4>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if ($product->sale_price)
                                        <h3 class="text-2xl font-playfair text-primary-950/60 font-bold">
                                            {{ '$' . $product->sale_price }}
                                        </h3>
                                        <h3 class="text-base font-playfair text-gray-400 line-through mt-0">
                                            {{ '$' . $product->price }}
                                        </h3>
                                    @else
                                        <h3 class="text-2xl font-playfair text-primary-950/60 mt-2">
                                            {{ '$' . $product->price }}
                                        </h3>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full mt-2">
                                <x-ui.button href="{{ $product->affiliate_link ?? route('product') }}"
                                    title="{{ $product->title }}" :wire="false" target="_blank"
                                    class="py-2! px-8! bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                                    <span class="text-white">{{ __('Discover Your Glow') }}</span>
                                    <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('No products found in this category.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Custom Pagination --}}
        @if ($this->shouldShowPagination())
            <div class="mt-8 sm:mt-12 px-2 sm:px-4">
                <div
                    class="flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-3 sm:gap-4 p-3 sm:p-6 rounded-xl sm:rounded-2xl">

                    {{-- Page Info - Left Side (Hidden on Mobile) --}}
                    <div class="hidden sm:flex text-sm font-inter">
                        <span class="text-gray-600">{{ __('Page') }}</span>
                        <span
                            class="mx-1 px-2.5 py-1 rounded-lg bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold text-base shadow-md">
                            {{ $currentPage }}
                        </span>
                        @if ($this->getTotalPages() > $currentPage)
                            <span class="text-gray-600">{{ __('of') }}</span>
                            <span class="ml-1 font-semibold text-gray-800">{{ $this->getTotalPages() }}</span>
                        @endif
                    </div>

                    {{-- Right Side Controls --}}
                    <div class="flex items-center gap-2 sm:gap-3">

                        {{-- Previous Button --}}
                        <button wire:click="previousPage" wire:loading.attr="disabled" wire:target="previousPage"
                            @if (!$this->hasPreviousPage()) disabled @endif
                            class="group relative px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-1 sm:gap-2 shadow-sm sm:shadow-md hover:shadow-lg sm:hover:shadow-xl hover:scale-105 disabled:hover:scale-100">

                            <svg class="w-3 h-3 sm:w-4 sm:h-4 transition-transform group-hover:-translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg>

                            <span wire:loading.remove wire:target="previousPage"
                                class="hidden sm:inline">{{ __('Previous') }}</span>
                            <span wire:loading wire:target="previousPage" class="hidden sm:inline">
                                <div class="relative">
                                    <div class="w-6 h-6 rounded-full border border-gray-200"></div>
                                    <div
                                        class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                    </div>
                                    <div class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                        style="animation-direction: reverse; animation-duration: 1s;"></div>
                                </div>
                            </span>
                        </button>

                        {{-- Page Numbers --}}
                        <div class="hidden md:flex items-center gap-1.5 sm:gap-2">
                            @php
                                $totalPages = $this->getTotalPages();
                                $start = max(1, $currentPage - 2);
                                $end = min($totalPages, $currentPage + 2);
                            @endphp

                            @if ($start > 1)
                                <button wire:click="goToPage(1)" wire:loading.attr="disabled"
                                    wire:target="goToPage(1)"
                                    class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-sm sm:shadow-md hover:shadow-lg hover:scale-105 text-sm sm:text-base">
                                    <span wire:loading.remove wire:target="goToPage(1)">1</span>
                                    <span wire:loading wire:target="goToPage(1)">
                                        <div class="relative">
                                            <div class="w-6 h-6 rounded-full border border-gray-200"></div>
                                            <div
                                                class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                            </div>
                                            <div class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                style="animation-direction: reverse; animation-duration: 1s;"></div>
                                        </div>
                                    </span>
                                </button>
                                @if ($start > 2)
                                    <span class="px-1 sm:px-2 text-gray-400 font-bold text-sm sm:text-base">...</span>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                <button wire:click="goToPage({{ $i }})" wire:loading.attr="disabled"
                                    wire:target="goToPage({{ $i }})"
                                    class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border-2 transition-all duration-300 font-semibold shadow-sm sm:shadow-md hover:shadow-lg hover:scale-105 text-sm sm:text-base
                                        {{ $i === $currentPage
                                            ? 'bg-gradient-to-r from-second-500 to-zinc-500 text-white border-transparent ring-2 ring-second-300'
                                            : 'border-second-500/40 bg-white hover:bg-second-50 text-gray-700' }}">

                                    <span wire:loading.remove
                                        wire:target="goToPage({{ $i }})">{{ $i }}</span>
                                    <span wire:loading wire:target="goToPage({{ $i }})">
                                        <div class="relative">
                                            <div class="w-6 h-6 rounded-full border border-gray-200"></div>
                                            <div
                                                class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                            </div>
                                            <div class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                style="animation-direction: reverse; animation-duration: 1s;"></div>
                                        </div>
                                    </span>
                                </button>
                            @endfor

                            @if ($end < $totalPages)
                                @if ($end < $totalPages - 1)
                                    <span class="px-1 sm:px-2 text-gray-400 font-bold text-sm sm:text-base">...</span>
                                @endif
                                <button wire:click="goToPage({{ $totalPages }})" wire:loading.attr="disabled"
                                    wire:target="goToPage({{ $totalPages }})"
                                    class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-sm sm:shadow-md hover:shadow-lg hover:scale-105 text-sm sm:text-base">
                                    <span wire:loading.remove
                                        wire:target="goToPage({{ $totalPages }})">{{ $totalPages }}</span>
                                    <span wire:loading wire:target="goToPage({{ $totalPages }})">
                                        <div class="relative">
                                            <div class="w-6 h-6 rounded-full border border-gray-200"></div>
                                            <div
                                                class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                            </div>
                                            <div class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                style="animation-direction: reverse; animation-duration: 1s;"></div>
                                        </div>
                                    </span>
                                </button>
                            @endif
                        </div>

                        {{-- Current Page (Mobile) --}}
                        <div
                            class="md:hidden px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold shadow-md sm:shadow-lg ring-2 ring-second-300 text-sm sm:text-base">
                            {{ $currentPage }}
                        </div>

                        {{-- Next Button --}}
                        <button wire:click="nextPage" wire:loading.attr="disabled" wire:target="nextPage"
                            @if (!$this->hasNextPage()) disabled @endif
                            class="group relative px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-1 sm:gap-2 shadow-sm sm:shadow-md hover:shadow-lg sm:hover:shadow-xl hover:scale-105 disabled:hover:scale-100">

                            <span wire:loading.remove wire:target="nextPage"
                                class="hidden sm:inline">{{ __('Next') }}</span>
                            <span wire:loading wire:target="nextPage" class="hidden sm:inline">
                                <div class="relative">
                                    <div class="w-6 h-6 rounded-full border border-gray-200"></div>
                                    <div
                                        class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                    </div>
                                    <div class="absolute top-0 left-0 w-6 h-6 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                        style="animation-direction: reverse; animation-duration: 1s;"></div>
                                </div>
                            </span>

                            <svg class="w-3 h-3 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
