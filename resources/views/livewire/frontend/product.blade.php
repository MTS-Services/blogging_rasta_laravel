<div>
    {{-- Product Section --}}
    <div class="container py-24">
        <h2 class="text-text-primary text-5xl font-bold font-montserrat">{{ __('Curated Products') }}</h2>
        <h6 class="text-base text-muted font-semibold font-inter mt-4">
            {{ __('All products handpicked by Diodio Glow • Shop from trusted affiliate stores') }}</h6>

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
                            <div class="mt-2">
                                {{-- <h3 class="text-2xl font-playfair text-primary-950/60">{{ '$' . $product->price }}
                                </h3> --}}
                                <div>
                                    @if ($product->sale_price)
                                        {{-- যদি sale price থাকে --}}
                                        <h3 class="text-2xl font-playfair text-primary-950/60 line-through">
                                            {{ '$' . $product->price }}
                                        </h3>
                                        <h3 class="text-2xl font-playfair text-zinc-500 font-bold">
                                            {{ '$' . $product->sale_price }}
                                        </h3>
                                    @else
                                        {{-- যদি sale price না থাকে --}}
                                        <h3 class="text-2xl font-playfair text-primary-950/60">
                                            {{ '$' . $product->price }}
                                        </h3>
                                    @endif
                                </div>
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

                            @php
                                $types = json_decode($product->product_types, true);
                            @endphp

                            @if ($types && is_array($types))
                                @foreach ($types as $type)
                                    <p
                                        class="text-base font-normal font-inter text-second-500 py-1 px-2.5 bg-second-500/10">
                                        {{ $type }}
                                    </p>
                                @endforeach
                            @else
                                <p
                                    class="text-base font-normal font-inter text-second-500 py-1 px-2.5 bg-second-500/10">
                                    {{ __('N/A') }}
                                </p>
                            @endif
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
