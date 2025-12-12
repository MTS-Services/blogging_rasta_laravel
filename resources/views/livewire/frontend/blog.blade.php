<div>

    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="Blog Beauté, Buzz & Astuces Skincare | DiodioGlow">
        <meta name="description"
            content="Suivez toute l'actualité du buzz au Sénégal, les dernières tendances TikTok et nos conseils d'experts pour une peau éclatante sur le blog DiodioGlow.">
        <meta name="keywords" content="Blog beauté Sénégal, Actualités people, Conseils skincare, Buzz 221">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website">
        <meta property="og:title" content="Blog Beauté, Buzz & Astuces Skincare | DiodioGlow">
        <meta property="og:description"
            content="Suivez toute l'actualité du buzz au Sénégal, les dernières tendances TikTok et nos conseils d'experts pour une peau éclatante sur le blog DiodioGlow.">
        <meta property="og:image" content="{{ site_logo() }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="{{ site_logo() }}">
        <link rel="image_src" href="{{ site_logo() }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Blog Beauté, Buzz & Astuces Skincare | DiodioGlow">
        <meta name="twitter:description"
            content="Suivez toute l'actualité du buzz au Sénégal, les dernières tendances TikTok et nos conseils d'experts pour une peau éclatante sur le blog DiodioGlow.">
        <meta name="twitter:image" content="{{ site_logo() }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection


    <div class="bg-gradient">
        <div class="container px-0 lg:px-24 pb-12 py-12">
            <h1 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center">{{ __('Blog') }}
            </h1>

            @foreach ($blogs as $index => $blog)
                @php $layout = $index % 2; @endphp

                @if ($layout === 0)
                    <div class="flex gap-12 items-center justify-between my-6 flex-col-reverse md:flex-row">
                        <div class="bg-second-500/15 p-6 flex-1 lg:flex-1/2 w-full">
                            <a href="{{ route('blog.details', $blog->slug) }}" title="{{ $blog->title }}" wire:navigate
                                class="inline-block mt-4 text-text-secondary">
                                <h3 class="text-3xl font-semibold text-text-primary line-clamp-2">
                                    {{ $blog->title }}
                                </h3>
                            </a>
                            <div class="line-clamp-6">
                                {!! $blog->description !!}
                            </div>


                        </div>
                        <div class="flex-1 lg:flex-1/2 mt-8 lg:mt-0 flex justify-center">
                            <x-blog-media :file="$blog->file" :alt="$blog->title" class="!object-cover" />
                        </div>
                    </div>
                @endif

                @if ($layout === 1)
                    <div class="flex gap-12 items-center justify-between my-6  flex-col md:flex-row">
                        <div class="flex-1 lg:flex-1/2 flex justify-center">
                            <x-blog-media :file="$blog->file" :alt="$blog->title" class="!object-cover" />
                        </div>

                        <div class="bg-blog p-6 flex-1 lg:flex-1/2 mt-8 lg:mt-0 w-full">
                            <a href="{{ route('blog.details', $blog->slug) }}" title="{{ $blog->title }}"
                                wire:navigate class="inline-block mt-4 text-text-secondary">
                                <h2 class="text-3xl font-semibold text-text-primary line-clamp-2">
                                    {{ $blog->title }}
                                </h2>
                            </a>


                            <div class="line-clamp-6">
                                {!! $blog->description !!}
                            </div>


                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
