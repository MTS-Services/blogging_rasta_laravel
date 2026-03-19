<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('blog.details')
            @php
                // Default: site logo (OG/Twitter need absolute HTTPS URLs)
                $ogImage = absolute_og_url(site_logo());
                $ogImageType = 'image/jpeg';
                $ogImageWidth = null;
                $ogImageHeight = null;

                $logoRel = app(\App\Services\ApplicationSettingsService::class)->findData('app_logo');
                if ($logoRel) {
                    $ogImageType = match (strtolower(pathinfo((string) $logoRel, PATHINFO_EXTENSION))) {
                        'webp' => 'image/webp',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        default => 'image/jpeg',
                    };
                }

                $fileRaw = $data->file ?? null;
                if (! empty($fileRaw)) {
                    if (\Illuminate\Support\Str::startsWith($fileRaw, ['http://', 'https://']) && str_contains((string) $fileRaw, '/storage/')) {
                        $ogImage = absolute_og_url($fileRaw);
                        $pathForExt = parse_url($ogImage, PHP_URL_PATH) ?? '';
                        $ext = strtolower(pathinfo($pathForExt, PATHINFO_EXTENSION));
                        if ($ext === '') {
                            $ext = strtolower(pathinfo((string) $fileRaw, PATHINFO_EXTENSION));
                        }
                        $ogImageType = match ($ext) {
                            'webp' => 'image/webp',
                            'png' => 'image/png',
                            'gif' => 'image/gif',
                            default => 'image/jpeg',
                        };
                    } else {
                        $relative = normalize_blog_storage_relative_path($fileRaw);
                        if ($relative && ! is_likely_video_storage_path($relative)) {
                            $localPath = storage_path('app/public/'.$relative);
                            $type = detectFileType($localPath);
                            $isRaster = is_likely_raster_image_storage_path($relative);
                            // "unknown" = file exists but mime_content_type not image/* (common for webp) — still use cover
                            $useBlogCover = $type === 'image'
                                || ($type === 'unknown' && is_file($localPath) && $isRaster)
                                || ($type === 'missing' && $isRaster);

                            if ($useBlogCover) {
                                if ($type === 'image' || ($type === 'unknown' && is_file($localPath) && $isRaster)) {
                                    $ogImage = absolute_og_url('storage/'.$relative);
                                    $ext = strtolower(pathinfo($relative, PATHINFO_EXTENSION));
                                    $ogImageType = match ($ext) {
                                        'webp' => 'image/webp',
                                        'png' => 'image/png',
                                        'gif' => 'image/gif',
                                        default => 'image/jpeg',
                                    };
                                    $dims = @getimagesize($localPath);
                                    if (is_array($dims)) {
                                        $ogImageWidth = $dims[0];
                                        $ogImageHeight = $dims[1];
                                    }
                                } else {
                                    $ogImage = absolute_og_url('og-image/'.rawurlencode($data->slug));
                                    $ogImageType = 'image/jpeg';
                                    $ogImageWidth = 1200;
                                    $ogImageHeight = 630;
                                }
                            }
                        }
                    }
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
                @if ($ogImageWidth && $ogImageHeight)
                    <meta property="og:image:width" content="{{ $ogImageWidth }}">
                    <meta property="og:image:height" content="{{ $ogImageHeight }}">
                @endif
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
