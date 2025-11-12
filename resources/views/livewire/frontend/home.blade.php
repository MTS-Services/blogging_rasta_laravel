<div class="">
    {{-- banner section --}}
    <div class="pt-7 container bg-gradient">
        <div class="flex justify-between gap-6 items-center">
            <div class="w-full">
                <div class="w-sm bg-second-500/40 rounded-full py-2 px-4">
                    <span class="text-xs text-muted font-inter font-normal">
                        <flux:icon name="sun" class="w-6 h-6 inline mr-2.5" />
                        {{ __('Trusted by 50K+ beauty lovers') }}
                    </span>
                </div>
                <h3 class="text-8xl font-semibold font-montserrat text-second-800 my-6"><span
                        class="text-zinc-900">{{ __('Glow') }}</span> {{ __('Naturally') }} </h3>
                <p class="text-xl text-text-primary font-medium font-inter">
                    {{ __('Discover routines that actually work. Explore trending videos, shop vetted products, and get personalized advice tailored to your skin type.') }}
                </p>
                <div class="flex gap-4 mt-6">
                    <div class="">
                        <x-ui.button href="#" class="w-auto py-2! bg-linear-to-br! from-second-500! to-zinc-500!">
                            {{ __('Discover Your Glow') }}
                            <flux:icon name="arrow-right"
                                class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                        </x-ui.button>
                    </div>
                    <div class="">
                        <x-ui.button href="#" class="w-auto py-2! border-second-500!" variant="secondary">
                            <flux:icon name="play"
                                class="w-4 h-4 stroke-text-primary group-hover:stroke-text-btn-primary" />
                            <span class="stroke-text-primary group-hover:text-zinc-50!">
                                {{ __('Watch Stories') }}</span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="w-[610px] h-[610px]">
                    <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="" class="w-full h-full">
                </div>

            </div>
        </div>
        <div class="flex gap-6 pb-24">
            <div class="p-6">
                <h3 class="text-5xl font-normal font-playfair text-second-800 mb-2">{{ __('50K+') }}</h3>
                <p class="text-base font-normal font-inter">{{ __('Followers') }}</p>
            </div>
            <div class="p-6">
                <h3 class="text-5xl font-normal font-playfair text-zinc-500 mb-2">{{ __('100+') }}</h3>
                <p class="text-base font-normal font-inter">{{ __('Products Curated') }}</p>
            </div>
            <div class="p-6">
                <h3 class="text-5xl font-normal font-playfair text-second-800 mb-2">{{ __('95%') }}</h3>
                <p class="text-base font-normal font-inter">{{ __('Satisfaction') }}</p>
            </div>
        </div>
    </div>



    {{-- Featured TikTok Clips section --}}
    <div class="container bg-bg-primary py-24">
        <div class="px-24">
            <h2 class="text-5xl text-text-primary font-bold font-montserrat">{{ __('Featured TikTok Clips') }}</h2>
            <p class="text-base  text-text-primary font-semibold font-inter mt-4">
                {{ __('The latest viral skincare trends everyone\'s talking about') }}</p>
        </div>
        {{-- video card --}}
        <div class="grid grid-cols-4 gap-7 mt-8 px-5">
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="w-[290px] h-[300px]">
                    <img src="{{ asset('assets/images/home_page/Image(video thumbnail).png') }}" alt=""
                        class="w-full h-full rounded-2xl">
                </div>
                <div class="flex gap-3 mt-2">
                    <div class="w-9 h-9">
                        <img src="{{ asset('assets/images/home_page/Image (user avatar).png') }}" alt=""
                            class="w-full h-full rounded-full">
                    </div>
                    <div class="">
                        <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                        <p class="text-ms font-normal text-text-primary font-outfit">{{ __('Creator name') }}</p>
                        <span class="text-xs font-normal text-muted mt-1">{{ __('2.3M views') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Trending --}}
    <div class="container bg-bg-secondary p-10">
        <div class="text-center">
            <h2 class="text-5xl text-text-primary font-bold font-montserrat">{{ __('Trending Hashtags') }}</h2>
            <span
                class="text-base  text-text-primary font-semibold font-inter mt-"4>{{ __('Join the conversation with beauty lovers worldwide') }}</span>
        </div>

        {{-- Hashtags card --}}
        <div class="grid grid-cols-4 gap-4 mt-4">
            <div class="bg-zinc-50 border border-zinc-500 rounded-xl py-2 px-4">
                <h2 class="text-2xl font-medium font-montserrat">{{ __('#GlowSkin') }}</h2>
                <span>{{ __('48 videos') }}</span>
            </div>
        </div>
    </div>
</div>
