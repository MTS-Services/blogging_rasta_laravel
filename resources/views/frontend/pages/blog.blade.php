<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('blog.details')
            @php
                $ogImage = \Illuminate\Support\Str::startsWith(site_logo(), 'http') ? site_logo() : url(site_logo());
                $ogImageWidth = 1200;
                $ogImageHeight = 630;
                $ogImageType = 'image/jpeg';
                if (!empty($data->file)) {
                    $path = storage_path('app/public/' . $data->file);
                    $type = detectFileType($path);
                    if ($type === 'image') {
                        $imgUrl = storage_url($data->file);
                        $ogImage = \Illuminate\Support\Str::startsWith($imgUrl, 'http') ? $imgUrl : url($imgUrl);
                        $ext = strtolower(pathinfo($data->file, PATHINFO_EXTENSION));
                        $ogImageType = $ext === 'png' ? 'image/png' : ($ext === 'gif' ? 'image/gif' : 'image/jpeg');
                    }
                }
                $ogImage = \Illuminate\Support\Str::startsWith($ogImage, 'http://') ? 'https://' . substr($ogImage, 7) : $ogImage;
            @endphp
            <x-slot name="meta">
                <meta name="title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
                <meta name="description" content="{!! $data->meta_description ?? Str::limit(html_entity_decode(strip_tags($data->description)), 160) !!}">
                <meta name="keywords" content="{{ $data->meta_keywords ? implode(',', $data->meta_keywords) : '' }}">
                <meta property="og:type" content="article">
                <meta property="og:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
                <meta property="og:description" content="{!! $data->meta_description ?? Str::limit(strip_tags($data->description), 200) !!}">
                <meta property="og:image" content="{{ $ogImage }}">
                <meta property="og:image:secure_url" content="{{ $ogImage }}">
                <meta property="og:image:width" content="{{ $ogImageWidth }}">
                <meta property="og:image:height" content="{{ $ogImageHeight }}">
                <meta property="og:image:type" content="{{ $ogImageType }}">
                <meta property="og:url" content="{{ url()->current() }}">
                <meta property="og:site_name" content="{{ config('app.name') }}">
                <meta property="og:image:alt" content="{{ Str::limit($data->title, 100) }}">
                <link rel="image_src" href="{{ $ogImage }}">
                <meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
                <meta name="twitter:description" content="{!! $data->meta_description ?? Str::limit(strip_tags($data->description), 200) !!}">
                <meta name="twitter:image" content="{{ $ogImage }}">
                <link rel="canonical" href="{{ url()->current() }}">
            </x-slot>
            <x-slot name="title">{{ $data->meta_title ?? Str::limit($data->title, 50) }}</x-slot>
            <x-slot name="pageSlug">{{ __('blog_details') }}</x-slot>
            <livewire:frontend.blog-details :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Blog Beauté, Buzz & Astuces Skincare | DiodioGlow') }}</x-slot>
            <x-slot name="pageSlug">{{ __('blog') }}</x-slot>
            <livewire:frontend.blog />
    @endswitch
</x-frontend::app>
