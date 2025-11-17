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

    {{-- <section class="bg-bg-tertiary/40 py-12 lg:py-24 mb-12 sm:mb-0">
        <div class="container">
            <h2 class="text-5xl font-bold font-montserrat pb-6 text-text-primary text-center">
                {{ __('Connect with Diodio Glow') }}</h2>
            <p class="text-base font-medium font-inter text-muted text-center">
                {{ __('Join the conversation with beauty lovers worldwide') }}</p>



            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 pt-16 max-w-5xl mx-auto">
                <div class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center">
                    <flux:icon name="instagram" class="w-10 h-10 stroke-zinc-500 mx-auto" />
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">{{ __('Instagram') }}</h2>
                    <p class="text-sm font-normal font-inter text-muted">{{ __('@diodio.glow') }}</p>
                </div>

                <div class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center">
                    <img src="{{ asset('assets/images/home_page/Vector (1).png') }}" alt=""
                        class="w-10 h-10 mx-auto">
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">{{ __('TikTok') }}</h2>
                    <p class="text-sm font-normal font-inter text-muted">{{ __('@diodio.glow') }}</p>
                </div>

                <div class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center">
                    <flux:icon name="youtube" class="w-10 h-10 stroke-zinc-500 mx-auto" />
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">{{ __('YouTube') }}</h2>
                    <p class="text-sm font-normal font-inter text-muted">{{ __('@diodio.glow') }}</p>
                </div>

                <div
                    class="w-full bg-white py-6 px-6 border border-second-500/30 rounded-lg text-center md:col-span-3 lg:col-span-1 md:max-w-xs md:mx-auto lg:max-w-full">
                    <flux:icon name="mail" class="w-10 h-10 stroke-zinc-500 mx-auto" />
                    <h2 class="text-2xl font-bold font-montserrat text-text-primary py-2">{{ __('Email') }}</h2>
                    <p class="text-sm font-normal font-inter text-muted">{{ __('@diodio.glow') }}</p>
                </div>
            </div>

            <p class="text-center text-sm font-inter text-text-primary pt-6">
                {{ __('Collaboration inquiries?') }}
                <a href="mailto:contact@diodioglow.com"
                    class="text-muted">{{ __('Email us for partnership opportunities.') }}</a>
            </p>

        </div>
    </section> --}}
    
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
