<div>
    <section class="bg-bg-primary py-24">
        <div class="container">
            <h2 class="text-5xl font-bold font-montserrat text-text-primary mb-2">
                {{ __('Curated Products') }}
            </h2>
            <p class="text-base text-text-muted font-inter mb-12">
                {{ __('All products handpicked by Diodio Glow – shop from trusted affiliate stores') }}
            </p>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Product Card --}}
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden border border-second-500/30 hover:shadow-lg transition-all duration-300">
                        <div class="w-full h-64 overflow-hidden">
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}"
                                class="w-full h-full object-cover">
                        </div>

                        <div class="p-6 text-left">
                            <h3 class="text-2xl font-semibold font-montserrat text-text-primary mb-1">
                                {{ __($product['title']) }}
                            </h3>

                            <div class="flex justify-between items-center mb-2">
                                <p class="text-lg font-medium text-text-secondary">{{ $product['price'] }}</p>
                                <div class="flex items-center text-sm text-second-500">
                                    <flux:icon name="star" class="w-4 h-4 fill-second-500 stroke-second-500" />
                                    <flux:icon name="star" class="w-4 h-4 fill-second-500 stroke-second-500" />
                                    <flux:icon name="star" class="w-4 h-4 fill-second-500 stroke-second-500" />
                                    <flux:icon name="star" class="w-4 h-4 fill-second-500 stroke-second-500" />
                                    <flux:icon name="star" class="w-4 h-4 fill-second-500 stroke-second-500" />
                                    <span class="ml-1 text-text-muted text-xs">({{ $product['rating'] }})</span>
                                </div>
                            </div>

                            <span
                                class="inline-block bg-second-100 text-second-800 text-xs font-medium px-3 py-1 rounded-full mb-4">
                                {{ $product['type'] }}
                            </span>

                            <x-ui.button href="#"
                                class="w-full py-3! btn-gradient rounded-md! flex justify-center items-center gap-2">
                                <span class="text-white font-medium">{{ __('Discover Your Glow') }}</span>
                                <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                            </x-ui.button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
