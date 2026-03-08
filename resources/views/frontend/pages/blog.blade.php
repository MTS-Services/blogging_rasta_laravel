<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('blog.details')
            @php
                $ogImageWidth = 1200;
                $ogImageHeight = 630;
                $ogImageType = 'image/jpeg';
                if (!empty($data->file)) {
                    $path = storage_path('app/public/' . $data->file);
                    $type = detectFileType($path);
                    if ($type === 'image') {
                        $ogImage = absolute_og_url('og-image/' . rawurlencode($data->slug));
                    } else {
                        $ogImage = absolute_og_url(site_logo());
                    }
                } else {
                    $ogImage = absolute_og_url(site_logo());
                }
                $canonicalUrl = absolute_og_url(request()->path());
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
                <meta property="og:url" content="{{ $canonicalUrl }}">
                <meta property="og:site_name" content="{{ config('app.name') }}">
                <meta property="og:image:alt" content="{{ Str::limit($data->title, 100) }}">
                <link rel="image_src" href="{{ $ogImage }}">
                <meta name="twitter:card" content="summary_large_image">
                <meta name="twitter:title" content="{{ $data->meta_title ?? Str::limit(html_entity_decode($data->title), 60) }}">
                <meta name="twitter:description" content="{!! $data->meta_description ?? Str::limit(strip_tags($data->description), 200) !!}">
                <meta name="twitter:image" content="{{ $ogImage }}">
                <link rel="canonical" href="{{ $canonicalUrl }}">
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

    @push('scripts')
    <script>
        (function() {
            function wrapBlogIframes() {
                document.querySelectorAll('.blog-content').forEach(function(container) {
                    container.querySelectorAll('iframe').forEach(function(iframe) {
                        if (iframe.closest('.blog-video-wrapper')) return;
                        var wrapper = document.createElement('div');
                        wrapper.className = 'blog-video-wrapper';
                        iframe.parentNode.insertBefore(wrapper, iframe);
                        wrapper.appendChild(iframe);
                    });
                });
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', wrapBlogIframes);
            } else {
                wrapBlogIframes();
            }
            document.addEventListener('livewire:navigated', wrapBlogIframes);
        })();
    </script>
    @endpush
</x-frontend::app>
