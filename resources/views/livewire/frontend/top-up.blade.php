<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{__('Home')}}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{__('Top Up')}}
            </h1>
        </div>

        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{__('Top Ups')}}</h2>
        </div>



        {{-- filter section --}}
        <div class="flex items-center justify-between my-10">
            <div class="w-full">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Top Up') }}</h2>
                <p class="text-text-white text-20px pt-3">
                    {{ __('Different from gift cards or vouchers, U7BUY provides a Top Up service with which you can add
                    funds directly to your balance. It contains a large variety, including mobile games, live
                    streaming, shopping, entertainment, etc.') }}
                </p>
            </div>
            <div class="w-full h-80">
                <img src="{{ asset('assets/images/items/top-up.png') }}" alt=""
                    class="w-full h-full object-cover">
            </div>
        </div>
        <div class="flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full" />
            </div>
            <div class="filter flex items-center">
                <div class="border border-primary rounded-xl h-10 w-30 flex items-center justify-center">
                    <img src="{{ asset('assets/icons/light.png') }}" alt="" class="w-5 h-5">
                    <p>{{__('Filter')}}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- popular top up --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{__('Popular Now')}}</h2>
            </div>
            <div class="swiper popular-toUp">
                <div class="swiper-wrapper py-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68">
                                    <img src="{{ asset('assets/images/items/ClashofClans.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Clash of Clans')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Fortnite.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Fortnite')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/GenshinImpact.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Genshin Impact')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                   {{ __(' See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/GenshinImpact.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Genshin Impact')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/GenshinImpact.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Genshin Impact')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
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
        </div>
    </section>

    {{-- Newly Launched --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="mb-10">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{__('Newly Launched')}}</h2>
            </div>
            <div class="swiper popular-launched">
                <div class="swiper-wrapper py-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68">
                                    <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('DarkWar: survival')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Kingshot.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Kingshot')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Last war:survival')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Last war:survival')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Lastwarsurvival.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Last war:survival')}}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
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
        </div>
    </section>

    {{-- All Game --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{__('All Game')}}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6">
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68">
                        <img src="{{ asset('assets/images/items/Rectangle163.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('League of Legends')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ArenaBreakout.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Arena Breakout')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/MonopolyGo.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Monopoly Go')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/AnimeStrike.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Anime Strike')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Standoff2.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Standoff2')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Fortnite2.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Fortnite')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/TikTok.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('TikTok')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/MoCo.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('MoCo')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/FreeFire.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{__('Free Fire')}}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!" href="{{ route('game.index',['categorySlug'=>'top-ups','gameSlug'=>'realmwalker-new-dawn']) }}" wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div>
    </section>


    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-toUp', {
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
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-launched', {
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
                            slidesPerView: 1,
                        },
                        768: {
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
