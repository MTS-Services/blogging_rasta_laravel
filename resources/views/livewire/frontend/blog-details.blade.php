<div>

    @php
        $path = storage_path('app/public/' . $data->file);
        $type = detectFileType($path);
    @endphp
    @section('meta')
        {{-- SEO PRIMARY TAGS --}}
        <meta name="title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
        <meta name="description" content="{!! $data->meta_description ?? Str::limit(html_entity_decode($data->description), 160) !!}">
        <meta name="keywords" content="{{ $data->meta_keywords ? implode(',', $data->meta_keywords) : '' }}">

        {{-- Open Graph / Facebook --}}
        <meta property="og:type" content="website" />
        <meta property="og:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}" />
        <meta property="og:description" content="{!! $data->meta_description ?? $data->description !!}" />
        <meta property="og:image" content="{{ $type == 'image' ? storage_url($data->file) : site_logo() }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="{{ $type == 'image' ? storage_url($data->file) : site_logo() }}">
        <link rel="image_src" href="{{ $type == 'image' ? storage_url($data->file) : site_logo() }}">

        {{-- Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
        <meta name="twitter:description" content="{!! $data->meta_description ?? Str::limit(html_entity_decode($data->description), 160) !!}">
        <meta name="twitter:image" content="{{ $type == 'image' ? storage_url($data->file) : site_logo() }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">
    @endsection
    <section class="bg-bg-primary">
        <div class="container pb-10">
            <div class="w-full pt-8 lg:pt-0 pb-5">
                <div class="w-full h-auto mx-auto">
                    <x-blog-media :file="$data->file" :alt="$data->title" />
                </div>
            </div>
            <h1 class="text-3xl font-semibold font-montserrat text-text-primary">
                {{ __($data->title) }}</h1>
            <p class="text-base pt-4  text-text-primary">
                {!! $data->description !!}
            </p>
        </div>
    </section>
</div>
