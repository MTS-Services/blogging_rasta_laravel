<div>
    <section class="bg-gradient">
        {{-- Banner Section --}}
        <div class="container pt-20 pb-16 lg:pt-24">
            <div class="flex flex-col-reverse lg:flex-row items-center justify-between gap-12">
                {{-- Text Content --}}
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    {{-- Small Badge --}}
                    <div class="inline-flex items-center bg-second-500/40 rounded-full py-2 px-4 mb-4">
                        <flux:icon name="sun" class="w-5 h-5 mr-2 text-second-500" />
                        <span class="text-xs text-text-muted font-inter">
                            {{ __('Trusted by 50K+ beauty lovers') }}
                        </span>
                    </div>

                    {{-- Heading --}}
                    <h1
                        class="text-5xl md:text-7xl lg:text-8xl font-semibold font-montserrat text-second-800 mb-6 leading-tight">
                        <span class="text-zinc-900">{{ __('Glow') }}</span> {{ __('Naturally') }}
                    </h1>

                    {{-- Description --}}
                    <p class="text-lg md:text-xl text-text-primary font-medium font-inter max-w-lg mx-auto lg:mx-0">
                        {{ __('Discover routines that actually work. Explore trending videos, shop vetted products, and get personalized advice tailored to your skin type.') }}
                    </p>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 mt-8">
                        <x-ui.button href="#"
                            class="py-4 px-8 bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                            <span class="text-white">{{ __('Discover Your Glow') }}</span>
                            <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                        </x-ui.button>

                        <x-ui.button href="#" variant="secondary"
                            class="py-4 px-8 border border-second-500 group transition-all duration-300">
                            <flux:icon name="play"
                                class="w-4 h-4 stroke-text-primary group-hover:stroke-white transition-colors" />
                            <span class="text-text-primary group-hover:text-white transition-colors">
                                {{ __('Watch Stories') }}
                            </span>
                        </x-ui.button>
                    </div>
                </div>

                {{-- Image Section --}}
                <div class="w-full lg:w-1/2 flex justify-center">
                    <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="Banner image"
                        class="w-full max-w-[500px] lg:max-w-none h-auto rounded-lg object-cover">
                </div>
            </div>

            {{-- Stats Section --}}
            <div class="flex flex-wrap justify-center lg:justify-start gap-10 mt-16">
                <div class="text-center lg:text-left">
                    <h3 class="text-4xl md:text-5xl font-playfair text-second-800 mb-1">{{ __('50K+') }}</h3>
                    <p class="text-base font-inter text-text-primary">{{ __('Followers') }}</p>
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-4xl md:text-5xl font-playfair text-zinc-500 mb-1">{{ __('100+') }}</h3>
                    <p class="text-base font-inter text-text-primary">{{ __('Products Curated') }}</p>
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-4xl md:text-5xl font-playfair text-second-800 mb-1">{{ __('95%') }}</h3>
                    <p class="text-base font-inter text-text-primary">{{ __('Satisfaction') }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-bg-primary">
        {{-- Featured TikTok Clips Section --}}
        <div class="container py-20 lg:py-24">
            {{-- Header --}}
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary">
                    {{ __('Featured TikTok Clips') }}
                </h2>
                <p class="text-base md:text-lg text-text-primary font-semibold font-inter mt-4">
                    {{ __('The latest viral skincare trends everyone\'s talking about') }}
                </p>
            </div>

            {{-- Video Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 mt-12 px-4">
                @foreach ($featuredVideos as $video)
                    <div class="group w-full">
                        {{-- Thumbnail --}}
                        <div class="relative w-full aspect-[1/1.1] overflow-hidden rounded-2xl">
                            <img src="{{ asset('assets/images/home_page/' . $video['thumb']) }}" alt="TikTok thumbnail"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            {{-- Play button overlay --}}
                            <div
                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40 rounded-2xl">
                                <flux:icon name="play" class="w-12 h-12 stroke-white" />
                            </div>
                        </div>

                        {{-- Creator Info --}}
                        <div class="flex items-center gap-3 mt-3">
                            <div class="w-10 h-10">
                                <img src="{{ asset('assets/images/home_page/' . $video['avatar']) }}" alt="User avatar"
                                    class="w-full h-full rounded-full object-cover">
                            </div>
                            <div>
                                <h6 class="text-text-primary font-semibold font-inter">{{ __('Getty') }}</h6>
                                <p class="text-sm font-normal text-text-primary font-outfit">{{ __('Creator name') }}
                                </p>
                                <span class="text-xs text-text-muted">{{ __('2.3M views') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-bg-secondary">
        {{-- Trending Hashtags --}}
        <div class="container py-20 lg:py-24 px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary mb-3">
                    {{ __('Trending Hashtags') }}
                </h2>
                <p class="text-base md:text-lg text-text-primary font-semibold font-inter">
                    {{ __('Join the conversation with beauty lovers worldwide') }}
                </p>
            </div>

            {{-- Hashtag Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($hashtags as $hash)
                    <div
                        class="bg-white border border-second-500/30 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <h3 class="text-2xl font-medium font-montserrat text-text-primary mb-1">
                            {{ __($hash['tag']) }}
                        </h3>
                        <span class="text-sm text-text-muted">{{ __($hash['videos'] . ' videos') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-second-200">
        {{-- Routine Section --}}
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary mb-4">
                {{ __('Ready to Find Your Perfect Routine?') }}
            </h2>
            <p class="text-base md:text-lg text-text-primary font-normal font-inter max-w-3xl mx-auto mb-8">
                {{ __('Discover routines tailored to your lifestyle. From skincare and fitness to productivity and wellness, our tips and guides help you build habits that stick — making everyday life simpler, healthier, and more enjoyable. Start your journey today!') }}
            </p>

            {{-- CTA Button --}}
            <div class="w-fit mx-auto">
                <x-ui.button href="#"
                    class="py-4 px-8 bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                    <span class="text-white">{{ __('Discover Your Glow') }}</span>
                    <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                </x-ui.button>
            </div>

            <p class="text-sm md:text-base font-normal font-inter text-text-muted mt-6">
                {{ __('It only takes 2 minutes. No signup required.') }}
            </p>
        </div>
    </section>

</div>
