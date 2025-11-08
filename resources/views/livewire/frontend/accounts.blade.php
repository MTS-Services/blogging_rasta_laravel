<main class="mx-auto">
    <section class="container mx-auto">
        {{-- paginate --}}
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-text-white text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{ __('Home') }}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{ __('Accounts') }}
            </h1>
        </div>



        {{-- filter section --}}
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Accounts') }}</h2>
        </div>
        <div class="flex items-center justify-between gap-4 mt-3.5">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full rounded-full!" />
            </div>
            <div class="flex items-center justify-between gap-4 relative" x-data={filter:false}>
                <button @click="filter = !filter"
                    class="flex items-center gap-2 border border-zinc-500! rounded-full px-5 py-2 hover:bg-zinc-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 7v5l-4 4v-9L3 6V4z" />
                    </svg>
                    <span>{{ __('Filter') }}</span>
                </button>
                <div class="absolute top-14 right-0 z-10 shadow-glass-card" x-show="filter" x-transition x-cloak
                    @click.outside="filter = false">
                    {{-- filter Options --}}
                    <div class="bg-bg-primary rounded-md p-4">
                        <div class="flex flex-col gap-2">
                            <button class="">{{ __('Option 1') }}</button>
                            <button class="">{{ __('Option 1') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- popular accounts --}}
    <section class="container mx-auto">
        <div class="mt-10">
            <div class="">
                <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('Popular Accoounts') }}
                </h2>
            </div>
            <div class="swiper popular-accounts">
                <div class="swiper-wrapper py-10">
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68">
                                    <img src="{{ asset('assets/images/items/Grand-Thef- Auto5.jpg') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Grand Theft Auto 5') }}
                                    </h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Valorant') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
                                    {{ __('See seller list') }}
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="p-6 bg-bg-primary rounded-2xl">
                            <div class="">
                                <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                                    <img src="{{ asset('assets/images/items/Call-of-Duty.png') }}" alt=""
                                        class="w-full h-full object-cover rounded-lg">
                                </div>
                                <div class="mt-5 mb-8">
                                    <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Call of Duty') }}</h2>
                                </div>
                            </div>
                            <div class="">
                                <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                                    href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                                    wire:navigate>
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
    {{-- all items --}}
    <section class="container mx-auto mt-10">
        <div class="mb-10">
            <h2 class="font-semibold text-text-white text-3xl sm:text-4xl md:text-5xl">{{ __('All Item') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 items-center gap-6 mb-16">
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68">
                        <img src="{{ asset('assets/images/items/language-legends.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('League of Legends') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Fortnite.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Fortnite') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/RainbowSixSiegeX.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Rainbow Six Siege X') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ClashRoyale.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Clash Royale') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Counter-Strike2.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Counter-Strike 2') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/CallofDuty.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Call of Duty') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/GrandTheftAuto5.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Grand Theft Auto 5') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Valorant1.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Valorant') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/Valorant.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Minecraft') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/ForzaHorizon5.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('Forza Horizon 5') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/WOWMistsOfPandariaClassic.jpg') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('WOW Mists') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
            <div class="p-6 bg-bg-primary rounded-2xl">
                <div class="">
                    <div class="w-full h-60 sm:h-48 md:h-68 rounded-2xl">
                        <img src="{{ asset('assets/images/items/1945USAirForce.png') }}" alt=""
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="mt-5 mb-8">
                        <h2 class="font-semibold ttext-xl md:text-2xl mb-3 mt-5  text-text-white">{{ __('1945 US Air Force') }}</h2>
                    </div>
                </div>
                <div class="">
                    <x-ui.button class="px-4! py-2! sm:px-6! sm:py-3!"
                        href="{{ route('game.index', ['categorySlug' => 'accounts', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                        wire:navigate>
                        {{ __('See seller list') }}
                    </x-ui.button>
                </div>
            </div>
        </div>

        {{-- <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div> --}}
    </section>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper('.popular-accounts', {
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
