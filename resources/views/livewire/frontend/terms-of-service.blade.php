<div>

    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="">
        <meta name="description" content="">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="">
        <meta property="og:description" content="">
        <meta property="og:image" content="">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="">
        <link rel="image_src" href="">

        {{-- Twitter --}}
        <meta name="twitter:card" content="{{ site_name() }}">
        <meta name="twitter:title" content="">
        <meta name="twitter:description" content="">
        <meta name="twitter:image" content="{{ site_logo() }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection
    <section class="bg-second-500/15  py-24">
        <div class="container">
            <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center mb-6">
                {{ __('Terms of Service') }}</h2>

            <p class="text-base font-normal font-montserrat text-text-primary">
                {{ __('By using DiodioGlow, you agree to the following terms:') }}
            </p>

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
