<div>
    {{-- Product Section --}}
    <div class="container py-24">
        <h2 class="text-text-primary text-5xl font-bold font-montserrat">{{ __('Curated Products') }}</h2>
        <h6 class="text-base text-muted font-semibold font-inter mt-4">
            {{ __('All products handpicked by Diodio Glow • Shop from trusted affiliate stores') }}</h6>


        {{-- <div class="flex flex-wrap gap-1 sm:gap-2 xl:ps-20 mb-5 xl:mb-10 max-w-2xl mx-auto">
            @foreach ($this->users as $user)
                @if ($user === 'All')
                    <button wire:click="setUser('{{ $user }}')"
                        class="px-1.5 sm:px-3 py-2 rounded-lg font-inter text-xs sm:text-sm font-medium transition-colors
                            {{ $activeUser === $user
                                ? 'bg-second-500 text-white'
                                : 'bg-second-800/10 text-second-500 hover:bg-second-400/40' }}">
                        {{ $user }}
                    </button>
                @else
                    @php
                        // Find actual username for this display name
                        $featuredUsers = config('tiktok.featured_users', []);
                        $userData = collect($featuredUsers)->firstWhere('display_name', $user);
                        $actualUsername = $userData['username'] ?? strtolower(str_replace(' ', '', $user));
                    @endphp
                    <a href="{{ route('user-video-feed', ['username' => $actualUsername]) }}" wire:navigate
                        class="px-1.5 sm:px-3 py-2 rounded-lg font-inter text-xs sm:text-sm font-medium transition-colors
                             {{ $activeUser === $user
                                 ? 'bg-second-500 text-white'
                                 : 'bg-second-800/10 text-second-500 hover:bg-second-400/40' }}">
                        {{ $user }}
                    </a>
                @endif
            @endforeach
        </div> --}}
        {{-- Filter --}}

        <div>
            <div class="mt-10">
                <h2 class="">{{ __('Select a category') }}</h2>
            </div>
            <!-- Category Filter Dropdown -->
            <div class="flex mb-5 xl:mb-10 max-w-2xl">
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
        {{-- <div class="mt-10">
         <h2 class="">{{ __('Select a category') }}</h2>
      </div>
        <div class="flex mb-5 xl:mb-10 max-w-2xl">
            
            <!-- Filter Dropdown -->
            <div class="relative w-48" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full px-4 py-2 rounded-lg font-inter text-sm font-medium transition-colors bg-second-500 text-white flex items-center justify-between">
                    <span class="text-white">{{ __('All') }}</span>
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
                    class="absolute z-10 mt-2 w-full rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="py-1">
                        <!-- All Option -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('All') }}
                        </button>

                        <!-- Oily -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Oily') }}
                        </button>

                        <!-- Dry -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Dry') }}
                        </button>

                        <!-- Combination -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Combination') }}
                        </button>

                        <!-- Sensitive -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Sensitive') }}
                        </button>

                        <!-- Normal -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Normal') }}
                        </button>

                        <!-- Cleanser -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Cleanser') }}
                        </button>

                        <!-- Moisturizer -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Moisturizer') }}
                        </button>

                        <!-- Serum -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Serum') }}
                        </button>

                        <!-- Sunscreen -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Sunscreen') }}
                        </button>

                        <!-- Toner -->
                        <button @click="open = false"
                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-second-500 hover:text-white transition-colors">
                            {{ __('Toner') }}
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Product Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-12 px-4">
            @foreach ($products as $product)
                <div class="group w-full p-6 border border-zinc-300/40 rounded-2xl">
                    {{-- Thumbnail --}}
                    <div class="relative w-full h-[300px] overflow-hidden rounded-2xl">
                        <img src="{{ storage_url($product->image) }}" alt="TikTok thumbnail"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                    </div>
                    <div class="mt-2">
                        <p class="text-xs text-text-primary font-normal font-outfit">{{ $product->category->title }}
                        </p>
                        <h4 class="text-xl font-lato font-medium text-text-primary">{{ $product->title }}
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
                            {{-- <div class="flex items-center">
                                <flux:icon name="star" class="w-3 h-3 stroke-second-500" />
                                <flux:icon name="star" class="w-3 h-3 stroke-second-500" />
                                <flux:icon name="star" class="w-3 h-3 stroke-second-500" />
                                <flux:icon name="star" class="w-3 h-3 stroke-second-500" />
                                <flux:icon name="star" class="w-3 h-3 stroke-muted" />
                                <p>{{ __('(324)') }}</p>
                            </div> --}}
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            {{-- @if (!empty($product->product_types))
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($product->product_types as $type)
                                        <p
                                        class="text-base font-normal font-inter text-second-500 py-1 px-2.5 bg-second-500/10">
                                        {{ $type }}
                                    </p>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-sm"></span>
                            @endif --}}
                        </div>
                        <div class="w-full! mt-2">
                            <x-ui.button href="#"
                                class="py-2! px-8! bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                                <span class="text-white">{{ __('Discover Your Glow') }}</span>
                                <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
