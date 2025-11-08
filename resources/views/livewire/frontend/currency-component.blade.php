<main class="overflow-x-hidden">
    {{-- filter section --}}
    <section class="container mx-auto">
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <a href="{{ route('home') }}"  class="text-base text-text-white">{{__('Home')}}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{ __('Currency') }}
            </h1>
        </div>


        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{__('Currency')}}</h2>
        </div>
        <div class="flex items-center justify-between gap-4 mt-10 relative" x-data={filter:false}>
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full rounded-full!" />
            </div>
            <button @click="filter = !filter"
                class="flex items-center gap-2 border border-zinc-500 rounded-full px-5 py-2 hover:bg-zinc-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                </svg>
                <span>{{__('Filter')}}</span>
            </button>
            <div class="absolute top-14 right-0 z-10 shadow-glass-card" x-show="filter" x-transition x-cloak @click.outside="filter = false">
                {{-- filter Options --}}
                <div class="bg-bg-primary rounded-md p-4">
                    <div class="flex flex-col gap-2">
                        <button class="">{{__('Option 1')}}</button>
                        <button class="">{{__('Option 1')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- popular currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mt-10">
            <h2 class="font-semibold text-40px">{{__('Popular Currency')}}</h2>
        </div>
        <div class="swiper popular-currency">
            <div class="swiper-wrapper py-10">
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-60 sm:h-48 md:h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163.png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('EA sports FC Coins')}}</h3>
                            <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-60 sm:h-48 md:h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (1).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold text-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Blade Ball Tokens')}}</h3>
                            <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-60 sm:h-48 md:h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (2).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('New World Coins')}}</h3>
                            <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-60 sm:h-48 md:h-68">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (1).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Blade Ball Tokens')}}</h3>
                            <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="bg-bg-primary p-6 rounded-2xl">
                        <div class="images w-full h-60 sm:h-48 md:h-68 md:min-h-48">
                            <img src="{{ asset('assets/images/home_page/Rectangle 163 (2).png') }}" alt=""
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div class="">
                            <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('New World Coins')}}</h3>
                            <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                            <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Pagination and Navigation -->
            <div class="mt-10">
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    {{-- All Currency --}}
    <section class="container mx-auto mt-10">
        <div class="title mb-10">
            <h2 class="font-semibold text-40px">{{__('All Currency')}}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-6">
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Exilecon Official Trailer')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'exilecon-official-trailer']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 164.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('RuneScape 3 Gold')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'runescape-3-gold']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 165.png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Silver Farming')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'silver-farming']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (6).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Hand Farmed Low Price')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'hand-farmed-low-price-gold']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (7).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('RuneScape 3 Gold')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'runescape-3-gold']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (8).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Free Club Coins FC25')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'free-club-coins-fc25']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (9).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Worldforge Legends')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'worldforge-legends']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (10).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Echoes of the Terra')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'echoes-of-the-terra']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (11).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Epochs of Gaia')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'epochs-of-gaia']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (12).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Titan Realms')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'titan-realms']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (13).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Kingdoms Across Skies')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'kingdoms-across-skies']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
            <div class="bg-bg-primary p-6 rounded-2xl">
                <div class="images w-full h-60 sm:h-48 md:h-68">
                    <img src="{{ asset('assets/images/currency_page/Rectangle 163 (14).png') }}" alt=""
                        class="w-full h-full object-cover rounded-lg">
                </div>
                <div class="">
                    <h3 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Realmwalker: New Dawn')}}</h3>
                    <p class="text-pink-500 mb-8">{{__('50 offer')}}</p>
                    <a href="{{ route('game.index',['categorySlug'=>'currency','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!">{{__('See Seller List')}}</x-ui.button>
                    </a>
                </div>
            </div>
        </div>
        <div class="pagination mb-24">
            <x-frontend.pagination-ui :pagination = "$pagination"/>
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-currency', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // navigation: {
                    //     nextEl: '.swiper-button-next',
                    //     prevEl: '.swiper-button-prev',
                    // },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
        </script>
    @endpush
</main>
