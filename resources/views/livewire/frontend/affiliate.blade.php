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

    <section class="bg-second-500/15  py-24 w-full flex flex-col items-center">
        <h1 class="text-4xl md:text-5xl font-bold text-new-light mb-12">
            {{ __('Affiliate Disclosure') }}
        </h1>

        <div class="max-w-7xl w-full rounded-xl border border-second-900/20 p-8">
            <h2 class="text-lg font-semibold text-new-light mb-4">
                {{ __('DiodioGlow participates in affiliate programs. This means:') }}
            </h2>

            <ul class="space-y-3 text-gray-700 leading-relaxed">

                <li class="flex gap-2">
                    <span class="text-new-light text-xl">•</span>
                    {{ __('Some links to products or brands may earn us a small commission when you make a purchase.') }}
                </li>

                <li class="flex gap-2">
                    <span class="text-new-light text-xl">•</span>
                    {{ __('This comes at no extra cost to you.') }}
                </li>

                <li class="flex gap-2">
                    <span class="text-new-light text-xl">•</span>
                    {{ __('We only feature products we believe bring genuine value to our audience.') }}
                </li>

                <li class="flex gap-2">
                    <span class="text-new-light text-xl">•</span>
                    {{ __('Your trust is important to us, and all affiliate-related content is reviewed carefully.') }}
                </li>
            </ul>
        </div>
    </section>



</div>
