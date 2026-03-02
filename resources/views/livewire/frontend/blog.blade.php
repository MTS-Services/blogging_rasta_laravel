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

            @if ($categories->isNotEmpty())
                @php
                    $currentCategorySlug = request()->query('category');
                @endphp
                <div class="flex flex-wrap items-center justify-center gap-2 py-5 xl:py-8 mx-auto">
                    <a href="{{ route('blog') }}" wire:navigate
                        class="px-4 py-2 rounded-lg font-inter text-sm font-medium transition-colors {{ !$currentCategorySlug ? 'bg-second-500 text-white shadow-md' : 'bg-white dark:bg-zinc-800 text-text-primary hover:bg-second-500 hover:text-white border border-zinc-200 dark:border-zinc-600' }}">
                        {{ __('All Categories') }}
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('blog', ['category' => $cat->slug]) }}" wire:navigate
                            class="px-4 py-2 rounded-lg font-inter text-sm font-medium transition-colors {{ $currentCategorySlug === $cat->slug ? 'bg-second-500 text-white shadow-md' : 'bg-white dark:bg-zinc-800 text-text-primary hover:bg-second-500 hover:text-white border border-zinc-200 dark:border-zinc-600' }}">
                            {{ $cat->title }}
                        </a>
                    @endforeach
                </div>
            @endif

            @foreach ($blogs as $index => $blog)
                @php $layout = $index % 2; @endphp

                @if ($layout === 0)
                    <div class="flex gap-12 items-center justify-between my-6 flex-col-reverse md:flex-row">
                        <div class="bg-second-500/15 p-6 flex-1 lg:flex-1/2 w-full">
                            @if ($blog->category)
                                <p><a href="{{ route('blog', ['category' => $blog->category->slug]) }}" wire:navigate class="text-sm font-medium">{{ $blog->category->title }}</a></p>
                            @endif
                            <a href="{{ route('blog.details', $blog->slug) }}" title="{{ $blog->title }}"
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
                            <x-blog-media :file="$blog->file" :alt="$blog->title" :eager="$index === 0" class="!object-cover" />
                        </div>
                    </div>
                @endif

                @if ($layout === 1)
                    <div class="flex gap-12 items-center justify-between my-6  flex-col md:flex-row">
                        <div class="flex-1 lg:flex-1/2 flex justify-center">
                            <x-blog-media :file="$blog->file" :alt="$blog->title" :eager="$index === 0" class="!object-cover" />
                        </div>

                        <div class="bg-blog p-6 flex-1 lg:flex-1/2 mt-8 lg:mt-0 w-full">
                            @if ($blog->category)
                                <p><a href="{{ route('blog', ['category' => $blog->category->slug]) }}" wire:navigate class="text-sm font-medium">{{ $blog->category->title }}</a></p>
                            @endif
                            <a href="{{ route('blog.details', $blog->slug) }}" title="{{ $blog->title }}"
                                 class="inline-block mt-4 text-text-secondary">
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

            {{-- Pagination --}}
            @if ($blogs->hasPages())
                <div class="mt-10 flex flex-wrap items-center justify-center gap-2">
                    @if ($blogs->onFirstPage())
                        <span class="px-4 py-2 rounded-lg bg-zinc-200 dark:bg-zinc-700 text-zinc-500 cursor-not-allowed text-sm">{{ __('Previous') }}</span>
                    @else
                        <button wire:click="previousPage" type="button" class="px-4 py-2 rounded-lg bg-bg-primary text-text-white hover:opacity-90 transition text-sm">
                            {{ __('Previous') }}
                        </button>
                    @endif
                    @php
                        $start = max(1, $blogs->currentPage() - 2);
                        $end = min($blogs->lastPage(), $blogs->currentPage() + 2);
                        if ($blogs->currentPage() <= 3) {
                            $end = min(5, $blogs->lastPage());
                        }
                        if ($blogs->currentPage() > $blogs->lastPage() - 3) {
                            $start = max(1, $blogs->lastPage() - 4);
                        }
                    @endphp
                    @if ($start > 1)
                        <button wire:click="gotoPage(1)" type="button" class="px-4 py-2 rounded-lg bg-bg-primary text-text-white hover:opacity-90 text-sm">1</button>
                        @if ($start > 2) <span class="px-2 text-text-muted">...</span> @endif
                    @endif
                    @for ($i = $start; $i <= $end; $i++)
                        <button wire:click="gotoPage({{ $i }})" type="button"
                            class="px-4 py-2 rounded-lg text-sm {{ $i === $blogs->currentPage() ? 'bg-bg-primary text-text-white font-semibold' : 'bg-bg-primary/80 text-text-white hover:opacity-90' }}">
                            {{ $i }}
                        </button>
                    @endfor
                    @if ($end < $blogs->lastPage())
                        @if ($end < $blogs->lastPage() - 1) <span class="px-2 text-text-muted">...</span> @endif
                        <button wire:click="gotoPage({{ $blogs->lastPage() }})" type="button" class="px-4 py-2 rounded-lg bg-bg-primary text-text-white hover:opacity-90 text-sm">{{ $blogs->lastPage() }}</button>
                    @endif
                    @if ($blogs->hasMorePages())
                        <button wire:click="nextPage" type="button" class="px-4 py-2 rounded-lg bg-bg-primary text-text-white hover:opacity-90 transition text-sm">{{ __('Next') }}</button>
                    @else
                        <span class="px-4 py-2 rounded-lg bg-zinc-200 dark:bg-zinc-700 text-zinc-500 cursor-not-allowed text-sm">{{ __('Next') }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
