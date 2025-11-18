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
        <div class="flex flex-wrap gap-1 sm:gap-2 xl:ps-20 mb-5 xl:mb-10 max-w-2xl mx-auto">
            
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
        </div>

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
