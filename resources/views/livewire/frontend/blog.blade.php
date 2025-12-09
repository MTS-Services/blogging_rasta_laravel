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


    <div class="bg-gradient">
        <div class="container px-0 lg:px-24 pb-12 py-12">
            <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center">{{ __('Blog') }}
            </h2>

            @foreach ($blogs as $index => $blog)
                @php $layout = $index % 2; @endphp

                @if ($layout === 0)
                    <div class="flex gap-12 items-center justify-between my-6 flex-col-reverse md:flex-row">
                        <div class="bg-second-500/15 p-6 flex-1 lg:flex-1/2 w-full">

                            <h3 class="text-3xl font-semibold text-text-primary line-clamp-2">
                                {{ $blog->title }}
                            </h3>

                            <a href="{{ route('blog.details', $blog->slug) }}" wire:navigate
                                class="inline-block mt-4 text-text-secondary">
                                <div class="line-clamp-6">
                                    {!! $blog->description !!}
                                </div>
                            </a>

                        </div>
                        <div class="flex-1 lg:flex-1/2 mt-8 lg:mt-0 flex justify-center">
                            <x-blog-media :file="$blog->file" class="!object-cover" />
                        </div>
                    </div>
                @endif

                @if ($layout === 1)
                    <div class="flex gap-12 items-center justify-between my-6  flex-col md:flex-row">
                        <div class="flex-1 lg:flex-1/2 flex justify-center">
                            <x-blog-media :file="$blog->file" class="!object-cover" />
                        </div>

                        <div class="bg-blog p-6 flex-1 lg:flex-1/2 mt-8 lg:mt-0 w-full">

                            <h3 class="text-3xl font-semibold text-text-primary line-clamp-2">
                                {{ $blog->title }}
                            </h3>

                            <a href="{{ route('blog.details', $blog->slug) }}" wire:navigate
                                class="inline-block mt-4 text-text-secondary">
                                <div class="line-clamp-6">
                                    {!! $blog->description !!}
                                </div>
                            </a>

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
