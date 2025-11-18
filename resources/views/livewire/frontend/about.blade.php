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
    <section class="bg-[#fcf8f6] py-16 lg:py-28">
        <div class="container mx-auto text-center">
            <h2 class="text-5xl font-bold font-montserrat text-text-primary pb-8">
                {{ __('Connect with Diodio Glow') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">

                @php
                    $cardClasses =
                        'w-full bg-white py-8 px-6 rounded-2xl shadow-lg border border-[#fce8d7] transition-all duration-300 transform hover:shadow-xl hover:translate-y-[-4px] hover:border-[#ffe4e4]';
                    $titleClasses = 'text-2xl font-bold font-montserrat text-text-primary pt-3 pb-1';
                    $iconClasses = 'w-12 h-12 mx-auto';
                @endphp


                <a href="{{ route('blog') }}" wire:navigate class="{{ $cardClasses }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff86a2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M12 14v7"></path>
                        <path d="M3 21h18"></path>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Blog</h3>
                    <p class="text-sm text-gray-500">Read the latest tips</p>
                </a>

                <a href="{{ route('video-feed') }}" wire:navigate class="{{ $cardClasses }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff6a8f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 16v1a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v1"></path>
                        <path d="M10 12l8 5 0-10-8 5z"></path>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Video Feed</h3>
                    <p class="text-sm text-gray-500">Watch our tutorials</p>
                </a>

                <a href="{{ route('product') }}" wire:navigate class="{{ $cardClasses }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff7c9c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Products</h3>
                    <p class="text-sm text-gray-500">Shop our collection</p>
                </a>

                <a href="mailto:contact@diodioglow.com" wire:navigate class="{{ $cardClasses }} lg:max-w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff98b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Contact</h3>
                    <p class="text-sm text-gray-500">Send us an email</p>
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
