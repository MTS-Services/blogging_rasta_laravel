<x-frontend::app>
    <x-slot name="title">{{ $video['title'] }}</x-slot>
    <x-slot name="pageSlug">{{ __('video-embed') }}</x-slot>
    @section('meta')
        <meta property="og:title" content="{{ $video['title'] ?? 'DioDioGlow Video' }}">
        <meta property="og:description" content="{!! $video['desc'] ? Str::limit(html_entity_decode($video['desc']), 160) : $video['title'] !!}">
        <meta property="og:image" content="{{ $video['thumbnail_url'] }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image:secure_url" content="{{ $video['thumbnail_url'] }}">
        <link rel="image_src" href="{{ $video['thumbnail_url'] }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $video['title'] }}">
        <meta name="twitter:description" content="{!! $video['desc'] ? Str::limit(html_entity_decode($video['desc']), 160) : $video['title'] !!}">
        <meta name="twitter:image" content="{{ $video['thumbnail_url'] }}">
    @endsection

    @section('head_scripts')
        <script type="application/ld+json">
            @php
            echo json_encode([
                "@context" => "https://schema.org",
                "@type" => "VideoObject",
                "name" => $video['title'],
                "description" => $video['desc']
                            ? Str::limit(strip_tags($video['desc']), 160)
                            : $video['title'],
                "thumbnailUrl" => [$video['thumbnail_url']],
                "uploadDate" => \Carbon\Carbon::parse($video['created_at'])->toIso8601String(),
                "contentUrl" => $video['play'],
                "interactionStatistic" => [
                    "@type" => "InteractionCounter",
                    "interactionType" => ["@type" => "WatchAction"],
                    "userInteractionCount" => $video['play_count'],
                ],
                "duration" => 'PT' . $video['duration'] . 'S',
                "embedUrl" => route('video.embed', $video['slug']),
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            @endphp
        </script>
    @endsection

    <style>
        header{
            display:none !important;
        }
        footer{
            display:none !important;
        }
    </style>



    @php
        // Extract video data
        $videoId = $video['video_id'];
        $slug = $video['slug'];
        $title = $video['title'] ?: 'TikTok Video';
        $cover = $video['cover'] ?? ($video['origin_cover'] ?? '');
        $thumbnail_url = $video['thumbnail_url'];
        $playUrl = $video['play'] ?? '';
        $createTime = $video['create_time'] ?? time();

        // Statistics
        $playCount = $video['play_count'] ?? 0;
        $diggCount = $video['digg_count'] ?? 0;
        $commentCount = $video['comment_count'] ?? 0;
        $shareCount = $video['share_count'] ?? 0;

        // Author info
        $author = $video['author'] ?? [];
        $username = $video['_username'] ?? ($author['unique_id'] ?? 'unknown');
        $authorName = $author['nickname'] ?? $username;
        $authorAvatar =
            $author['avatar'] ??
            'https://ui-avatars.com/api/?name=' . urlencode($authorName) . '&size=200&background=667eea&color=fff';
    @endphp
    <div x-data="{
        playing: false,
        playVideo() {
            this.playing = true;
            this.$nextTick(() => {
                const video = this.$refs.video;
                if (video) {
                    document.querySelectorAll('video').forEach(v => {
                        if (v !== video && !v.paused) v.pause();
                    });
                    video.play().catch(err => {
                        console.error('Play error:', err);
                        this.playing = false;
                    });
                }
            });
        },
        stopVideo() {
            this.playing = false;
            if (this.$refs.video) {
                this.$refs.video.pause();
                this.$refs.video.currentTime = 0;
            }
        }
    }" class="group w-full">
        {{-- Video Container --}}
        <div class="relative w-full aspect-[1/1.1] overflow-hidden rounded-2xl">
            @if ($playUrl)
                {{-- Video Element --}}
                <video x-ref="video"  height='100vh' width='100%' x-show="playing" x-on:ended="stopVideo()" x-on:error="playing = false"
                    class="w-full h-screen object-cover" poster="{{ $thumbnail_url }}" playsinline preload="metadata"
                    controls controlsList="nodownload" x-cloak>
                    <source src="{{ $playUrl }}" type="video/mp4">
                </video>

                {{-- Thumbnail --}}
                <div x-show="!playing" style="height:100vh; width:100%" x-on:click="playVideo()" class="absolute inset-0 cursor-pointer">
                    @if ($thumbnail_url)
                        <img src="{{ $thumbnail_url }}" alt="{{ $title }}" class="w-full h-screen object-cover"
                            loading="lazy">
                    @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Play button overlay --}}
                    <div
                        class="absolute inset-0 flex items-center justify-center transition-all duration-300 hover:bg-opacity-50">
                        <div class="transform hover:scale-110 transition-transform duration-300">
                            <div class="w-20 h-20 flex items-center justify-center">
                                <flux:icon name="play" class="w-full h-full stroke-white/60 fill-white/50" />
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- No video available --}}
                <div
                    class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex flex-col items-center justify-center text-white">
                    <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                    </svg>
                    <p class="text-sm">Video unavailable</p>
                </div>
            @endif
        </div>
    </div>

</x-frontend::app>
