<div>

    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="Conditions Générales d'Utilisation | DiodioGlow CGU">
        <meta name="description"
            content="Veuillez lire attentivement les conditions générales d'utilisation de DiodioGlow. Tout ce que vous devez savoir sur les règles, les droits et l'accès à notre plateforme.">
        <meta name="keywords" content="Conditions d'utilisation, CGU, Règlement site web, Termes légaux">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="Conditions Générales d'Utilisation | DiodioGlow CGU">
        <meta property="og:description"
            content="Veuillez lire attentivement les conditions générales d'utilisation de DiodioGlow. Tout ce que vous devez savoir sur les règles, les droits et l'accès à notre plateforme.">
        <meta property="og:image" content="{{ site_logo() }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="{{ site_logo() }}">
        <link rel="image_src" href="{{ site_logo() }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Conditions Générales d'Utilisation | DiodioGlow CGU">
        <meta name="twitter:description"
            content="Veuillez lire attentivement les conditions générales d'utilisation de DiodioGlow. Tout ce que vous devez savoir sur les règles, les droits et l'accès à notre plateforme.">
        <meta name="twitter:image" content="{{ site_logo() }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection
    <section class="bg-second-500/15  py-24">
        <div class="container">
            <h1 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center mb-6">
                {{ __('Terms of Service') }}</h1>

            <h2 class="text-base font-normal font-montserrat text-text-primary">
                {{ __('By using DiodioGlow, you agree to the following terms:') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 justify-between items-center mt-6">
                <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg h-full">
                    <flux:icon name="lock" class="w-5 h-5 mr-2 text-second-500" />
                    <div class="">
                        <h6p class="text-base font-semibold font-inter text-text-primary">
                            {{ __('Use of the Platform') }}
                        </h6p>
                        <ul class="text-base font-normal font-inter text-text-primary list-disc pl-5 mt-2">
                            <li class="text-base font-normal font-inter text-muted mt-1">
                                {{ __('You must be at least 13 years old.') }}</li>
                            <li class="text-base font-normal font-inter text-muted mt-1">
                                {{ __('You may not misuse the platform, upload harmful content, or infringe on others’ rights.') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg h-full">
                    <flux:icon name="chart-no-axes-gantt" class="w-5 h-5 mr-2 text-second-500" />
                    <div class="">
                        <h6 class="text-base font-semibold font-inter text-text-primary">{{ __('Content') }}
                        </h6>
                        <ul class="text-base font-normal font-inter text-text-primary list-disc pl-5 mt-2">
                            <li class="text-base font-normal font-inter text-muted mt-1">
                                {{ __('Some content is user-generated; we are not responsible for external sources or third-party videos.') }}
                            </li>
                            <li class="text-base font-normal font-inter text-muted mt-1">
                                {{ __('We may update, modify, or remove features without prior notice.') }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg h-full">
                    <flux:icon name="shield-off" class="w-5 h-5 mr-2 text-second-500" />
                    <div class="">
                        <h6 class="text-base font-semibold font-inter text-text-primary">
                            {{ __('Limitation of Liability') }}
                        </h6>
                        <p class="text-base font-normal font-inter text-muted list-disc pl-5 mt-2">
                            {{ __('DiodioGlow is not responsible for any damage, skincare reactions, or inaccuracies from curated content or product suggestions.') }}
                        </p>
                    </div>
                </div>
                <div class="flex gap-2 p-6 border border-zinc-200 rounded-lg h-full">
                    <flux:icon name="chart-no-axes-gantt" class="w-5 h-5 mr-2 text-second-500" />
                    <div class="">
                        <h6 class="text-base font-semibold font-inter text-text-primary">
                            {{ __('Account Termination') }}
                        </h6>
                        <p class="text-base font-normal font-inter text-muted list-disc pl-5 mt-2">
                            {{ __('We reserve the right to suspend accounts for misuse or violation of these terms.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
