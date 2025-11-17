<div>

    <section class="bg-gradient mb-12 sm:mb-0">
        {{-- Banner Section --}}
        <div class="container pt-20 pb-16 lg:pt-24">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-14">
                {{-- Image Section --}}
                <div class="w-full lg:w-1/2 flex justify-center">
                    <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="Banner image"
                        class="w-full max-w-[500px] lg:max-w-none h-auto rounded-lg object-cover block">
                </div>

                {{-- Text Content --}}
                <div class="w-full lg:w-1/2 lg:text-left">

                    <div>
                        <p class="text-xs font-normal text-muted font-inter pb-4 text-center lg:text-left">
                            {{ __('About the Founder') }}</p>
                        {{-- Heading --}}
                        <h2
                            class="text-5xl font-bold font-montserrat text-second-800 pb-6 text-text-primary lg:text-left">
                            {{ __('Meet Diodio Glow') }}</h2>
                        {{-- Description --}}
                        <p class="text-base text-text-primary font-normal font-inter lg:text-left">
                            {{ __('Diodio Glow is one of Senegal\'s most popular skincare and beauty influencers, with a passionate community of 50K+ followers who trust her recommendations.') }}
                        </p>
                        <p class="text-base text-text-primary font-normal font-inter mt-8 lg:text-left">
                            {{ __('From viral TikTok routines to honest product reviews, she\'s dedicated to helping women discover their natural glow. Her approach is authentic, affordable, and rooted in celebrating the beauty of diverse African skin.') }}
                        </p>
                        <p class="text-base text-text-primary font-normal font-inter mt-8 lg:text-left">
                            {{ __('This platform brings together her favorite skincare finds, trending routines, and AI-powered personalized recommendations—everything you need to build a routine that works for YOUR skin.') }}
                        </p>
                    </div>

                    <div class="pt-16">
                        <div class="flex gap-2 items-center lg:text-left">
                            <flux:icon name="check" class="w-6 h-6 stroke-second-50 bg-second-500 rounded-full" />
                            <p class="text-base text-text-primary font-semibold font-inter">
                                {{ __('50K+ followers across TikTok, Instagram & YouTube') }}</p>
                        </div>
                        <div class="flex gap-2 items-center pt-10 lg:text-left">
                            <flux:icon name="check" class="w-6 h-6 stroke-second-50 bg-second-500 rounded-full" />
                            <p class="text-base text-text-primary font-semibold font-inter">
                                {{ __('100+ curated products handpicked for quality and affordability') }}</p>
                        </div>
                        <div class="flex gap-2 items-center pt-10 lg:text-left">
                            <flux:icon name="check" class="w-6 h-6 stroke-second-50 bg-second-500 rounded-full" />
                            <p class="text-base text-text-primary font-semibold font-inter">
                                {{ __('95% satisfaction rate from product recommendations') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-bg-tertiary/40 py-12 lg:py-24 mb-12 sm:mb-0">
        <div class="container">
            <h2 class="text-5xl font-bold font-montserrat pb-6 text-text-primary text-center">
                {{ __('Connect with Diodio Glow') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 pt-16 max-w-5xl mx-auto">

                <!-- Blog -->
                <a href="{{ route('blog') }}" wire:navigate
                    class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center block">
                    <!-- Hero Icon: Book Open -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-zinc-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 20h9M3 20h9M4 4h16M4 8h16M4 12h16M4 16h16" />
                    </svg>
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">Blog</h2>
                </a>

                <!-- Video Feed -->
                <a href="{{ route('video-feed') }}" wire:navigate
                    class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center block">
                    <!-- Hero Icon: Video Camera -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-zinc-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m0-4v4m0-4L9 10v4l6-2z" />
                    </svg>
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">Video Feed</h2>
                </a>

                <!-- Products -->
                <a href="{{ route('product') }}" wire:navigate
                    class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center block">
                    <!-- Hero Icon: Shopping Bag -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-zinc-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V5a4 4 0 00-8 0v6M5 11h14l1 10H4L5 11z" />
                    </svg>
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">Products</h2>
                </a>

                <!-- Contact -->
                <a href="mailto:contact@diodioglow.com" wire:navigate
                    class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center md:col-span-3 lg:col-span-1 md:max-w-xs md:mx-auto lg:max-w-full block">
                    <!-- Hero Icon: Mail -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto text-zinc-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 0v8a2 2 0 002 2h14a2 2 0 002-2V8m-18 0l9 6 9-6" />
                    </svg>
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">Contact</h2>
                </a>

            </div>
        </div>
    </section>


    <section class="bg-bg-tertiary mb-12 sm:mb-0">
        <div class="container py-12">
            <h2 class="text-5xl font-bold font-montserrat pb-6 text-text-primary ">{{ __('Our Mission') }}</h2>
            <p class="text-base font-normal font-inter text-muted ">
                {{ __('We believe skincare should be accessible, transparent, and celebrating. That\'s why DiodioGlow.com exists—to democratize beauty recommendations and empower everyone with personalized skincare guidance.') }}
            </p>
            <p class="text-base font-normal font-inter text-muted mt-6">
                {{ __('Every product, every video, every recommendation is rooted in authenticity and the belief that beautiful skin starts with understanding YOUR unique needs.') }}
            </p>
        </div>
    </section>

</div>
