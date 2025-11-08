<main class="mx-auto">
    {{-- Gift Card header --}}
    <section class="container mx-auto mt-10">
        <div class="flex items-center gap-1 my-10 font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <div class="text-muted text-base">
                <a href="{{ route('home') }}" class="text-base text-text-white">{{ __('Home') }}</a>
            </div>
            <div class="px-2 text-text-white text-base">
                >
            </div>
            <h1 class="text-text-white text-base">
                {{ __('Gift Cards') }}
            </h1>
        </div>
        <div class="title mb-5">
            <h2 class="font-semibold text-4xl">{{ __('Gift Cards') }}</h2>
        </div>

        <div class="flex items-center justify-between gap-4 my-10">
            <div class="search w-full">
                <x-ui.input type="text" wire:model.live.debounce.300ms="search" placeholder="Search..."
                    class="form-input w-full rounded-full!" />
            </div>
            <div class="flex items-center justify-between gap-4 relative" x-data={filter:false}>

                <button @click="filter = !filter"
                    class="flex items-center gap-2 border border-purple-500 rounded-full px-5 py-2 hover:bg-purple-600 transition">
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
    {{-- Gift Cards --}}
    <section class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/1.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/2.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/3.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/4.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/5.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/6.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/7.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/8.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/9.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/10.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/11.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/12.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/13.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/14.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/15.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/16.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/17.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/18.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/19.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('game.index', ['categorySlug' => 'gift-cards', 'gameSlug' => 'realmwalker-new-dawn']) }}"
                wire:navigate>
                <div class="w-full h-72 relative">
                    <img src="{{ asset('assets/images/gift_cards/20.png') }}" alt="" class="w-full h-full">
                    <div class="absolute top-2.5 right-2.5">
                        <span
                            class="text-xs bg-zinc-500 font-medium px-4 py-1 rounded-full">{{ __('4 offerd') }}</span>
                    </div>
                </div>
            </a>
        </div>
        {{-- <div class="pagination mb-24">
            <x-frontend.pagination-ui />
        </div> --}}
    </section>
</main>
