<div>
    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="Support Client & Centre d'Aide | DiodioGlow Assistance">
        <meta name="description"
            content="Besoin d'aide ? Contactez l'équipe de support DiodioGlow pour toute question technique, problème d'accès ou demande d'information sur nos services.">
        <meta name="keywords" content="Support client, Assistance technique, Centre d'aide, FAQ DiodioGlow">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="Support Client & Centre d'Aide | DiodioGlow Assistance">
        <meta property="og:description"
            content="Besoin d'aide ? Contactez l'équipe de support DiodioGlow pour toute question technique, problème d'accès ou demande d'information sur nos services.">
        <meta property="og:image" content="{{ site_logo() }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="{{ site_logo() }}">
        <link rel="image_src" href="{{ site_logo() }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Support Client & Centre d'Aide | DiodioGlow Assistance">
        <meta name="twitter:description"
            content="Besoin d'aide ? Contactez l'équipe de support DiodioGlow pour toute question technique, problème d'accès ou demande d'information sur nos services.">
        <meta name="twitter:image" content="{{ site_logo() }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection

    <section class="bg-second-500/15  py-24">
        <div class="container">
            <h1 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center mb-6">
                {{ __('Support') }}</h1>

            <h2 class="text-base font-normal font-montserrat text-text-primary">
                {{ __('Need help? We’re here for you.') }}
            </h2>

            <div class="flex flex-col lg:flex-row gap-10 items-stretch">
                <!-- Left Column: 2-column grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 flex-1">
                    <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg">
                        <flux:icon name="circle-question-mark" class="w-5 h-5 mr-2 text-second-500 flex-shrink-0" />
                        <div>
                            <h6 class="text-base font-semibold font-inter text-text-primary">
                                {{ __('General Help') }}
                            </h6>
                            <p class="text-base font-normal font-inter text-muted mt-2">
                                {{ __('Find answers to common questions about routines, videos, and product browsing.') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg">
                        <flux:icon name="mail" class="w-5 h-5 mr-2 text-second-500 flex-shrink-0" />
                        <div>
                            <h6 class="text-base font-semibold font-inter text-text-primary">{{ __('Contact Us') }}
                            </h6>
                            <a href="mailto:diodioglowsn@gmail.com"
                                class="text-base font-normal font-inter text-muted mt-2 block">
                                {{ __('Email: diodioglowsn@gmail.com') }}
                            </a>
                            <p class="text-base font-normal font-inter text-muted mt-2">
                                {{ __('Response time: 24–48 hours.') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg">
                        <flux:icon name="key-round" class="w-5 h-5 mr-2 text-second-500 flex-shrink-0" />
                        <div>
                            <h6 class="text-base font-semibold font-inter text-text-primary">
                                {{ __('Support & Assistance') }}
                            </h6>
                            <div class="space-y-4 mt-4">
                                <div class="border border-zinc-200 rounded-lg py-2 px-3">
                                    <strong>{{ __('Contact Support') }}</strong>
                                    <p class="text-sm text-text-secondary mt-1">
                                        {{ __('Reach out to our support team for any inquiries or help you need.') }}
                                    </p>
                                </div>
                                <div class="border border-zinc-200 rounded-lg py-2 px-3">
                                    <strong>{{ __('Product Guides') }}</strong>
                                    <p class="text-sm text-text-secondary mt-1">
                                        {{ __('Learn how to make the most of our products with step-by-step guides.') }}
                                    </p>
                                </div>
                                <div class="border border-zinc-200 rounded-lg py-2 px-3">
                                    <strong>{{ __('Community Forums') }}</strong>
                                    <p class="text-sm text-text-secondary mt-1">
                                        {{ __('Join discussions with other users and share tips and solutions.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg">
                        <flux:icon name="chart-no-axes-gantt" class="w-5 h-5 mr-2 text-second-500 flex-shrink-0" />
                        <div>
                            <h6 class="text-base font-semibold font-inter text-text-primary">
                                {{ __('Community & Feedback') }}
                            </h6>
                            <p class="text-base font-normal font-inter text-muted mt-2">
                                {{ __('Share suggestions or report an issue so we can continue improving your experience.') }}
                            </p>
                            <div class="w-fit mt-2.5">
                                <x-ui.button href="{{ 'contact' }}"
                                    class="py-2! px-4! bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                                    <flux:icon name="send" class="w-4 h-4 stroke-white" />
                                    <span class="text-white">{{ __('Send feedback') }}</span>
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Single card -->
                <div class="flex gap-2 py-7 px-6 border border-zinc-200 rounded-lg w-80 max-w-md mx-auto lg:mx-0">
                    <flux:icon name="list-indent-increase" class="w-5 h-5 mr-2 text-second-500 flex-shrink-0" />
                    <div class="flex-1">
                        <h6 class="text-base font-semibold font-inter text-text-primary">
                            {{ __('Resources') }}
                        </h6>
                        <div class="space-y-4 mt-4">
                            <a wire:navigate="{{ route('PrivacyPolicy') }}"
                                class="border border-zinc-200 rounded-lg py-1 px-2 inline-block">
                                {{ __('Privacy Policy') }}
                            </a>
                            <a wire:navigate="{{ route('TermsOfService') }}"
                                class="border border-zinc-200 rounded-lg py-1 px-2 inline-block">
                                {{ __('Terms of Service') }}
                            </a>
                            <a wire:navigate="{{ route('affiliate') }}"
                                class="border border-zinc-200 rounded-lg py-1 px-2 inline-block">
                                {{ __('Affiliate Disclosure') }}
                            </a>
                        </div>

                        <h6 class="text-base font-semibold font-inter text-text-primary mt-6">
                            {{ __('Community & Feedback') }}
                        </h6>
                        <p class="text-base font-normal font-inter text-muted mt-2">
                            {{ __('Share suggestions or report an issue so we can continue improving your experience.') }}
                        </p>
                        <div class="w-full mt-2.5">
                            <x-ui.button href="#"
                                class="py-2! px-4! bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300 w-full">
                                <flux:icon name="mail" class="w-4 h-4 stroke-white" />
                                <span class="text-white">
                                    <a href="mailto:diodioglowsn@gmail.com"
                                        class="hover:underline duration-300 hover:text-zinc-300">{{ __('Email Support') }}</a>
                                </span>
                            </x-ui.button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>
