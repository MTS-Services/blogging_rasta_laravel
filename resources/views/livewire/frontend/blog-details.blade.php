<div>

    @php
        $ogImage = \Illuminate\Support\Str::startsWith(site_logo(), 'http') ? site_logo() : url(site_logo());
        $ogImageWidth = 1200;
        $ogImageHeight = 630;
        if (!empty($data->file)) {
            $path = storage_path('app/public/' . $data->file);
            $type = detectFileType($path);
            if ($type === 'image') {
                $imgUrl = storage_url($data->file);
                $ogImage = \Illuminate\Support\Str::startsWith($imgUrl, 'http') ? $imgUrl : url($imgUrl);
            }
        } else {
            $type = 'missing';
        }
    @endphp
    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
        <meta name="description" content="{!! $data->meta_description ?? Str::limit(html_entity_decode($data->description), 160) !!}">
        <meta name="keywords" content="{{ $data->meta_keywords ? implode(',', $data->meta_keywords) : '' }}">

        {{-- Open Graph / Facebook / WhatsApp / Telegram (absolute URL + dimensions for full-size preview) --}}
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}" />
        <meta property="og:description" content="{!! $data->meta_description ?? Str::limit(strip_tags($data->description), 200) !!}" />
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:image:secure_url" content="{{ $ogImage }}">
        <meta property="og:image:width" content="{{ $ogImageWidth }}">
        <meta property="og:image:height" content="{{ $ogImageHeight }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <link rel="image_src" href="{{ $ogImage }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
        <meta name="twitter:description" content="{!! $data->meta_description ?? Str::limit(strip_tags($data->description), 200) !!}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection
    <section class="bg-bg-primary">
        <div class="container pb-10">
            @if(!empty($data->file))
            <div class="w-full pt-8 lg:pt-0 pb-5">
                <div class="w-full h-auto mx-auto">
                    <x-blog-media :file="$data->file" :alt="$data->title" />
                </div>
            </div>
            @endif
            @if($data->category)
                <a href="{{ route('blog', ['category' => $data->category->slug]) }}" wire:navigate class="inline-block text-sm text-bg-primary font-medium mb-2">{{ $data->category->title }}</a>
            @endif
            <h1 class="text-3xl font-semibold font-montserrat text-text-primary">
                {{ __($data->title) }}</h1>
            <p class="text-base pt-4  text-text-primary">
                {!! $data->description !!}
            </p>

            <livewire:frontend.blog-post-comments :blog="$data" />
        </div>
    </section>
</div>
