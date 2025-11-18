<div class="min-h-screen bg-bg-primary py-8 sm:py-12 px-4">
    <div class="container mx-auto">
        <div id="user-video-section">
            {{-- Header --}}
            <div class="mb-3 sm:mb-5 lg:mb-8 mx-auto max-w-xl">
                {{-- Back Button --}}
                <a href="{{ route('video-feed') }}" wire:navigate
                    class="inline-flex items-center gap-2 text-second-500 hover:text-second-600 mb-4 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="font-medium">{{ __('Back to All Videos') }}</span>
                </a>

                <h1 class="text-2xl sm:text-3xl md:text-4xl xl:text-5xl font-bold text-text-primary mb-1.5 sm:mb-3">
                    {{ $displayName }}
                </h1>
                <p class="text-text-secondary text-base">
                    {{ __('Videos from') }} {{ $displayName }}
                </p>
            </div>

            {{-- Loading State --}}
            @if ($loading)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                    @for ($i = 0; $i < 12; $i++)
                        <div class="animate-pulse bg-bg-primary p-4 rounded-2xl shadow-md border border-second-500/40">
                            <div class="bg-gray-300 w-full h-80 rounded-lg mb-2"></div>
                            <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                            <div class="h-3 bg-gray-300 rounded w-1/2 mb-4"></div>
                            <div class="flex gap-4 py-2 border-t border-b">
                                <div class="h-5 bg-gray-300 rounded w-12"></div>
                                <div class="h-5 bg-gray-300 rounded w-12"></div>
                                <div class="h-5 bg-gray-300 rounded w-12"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            @endif

            {{-- Error State --}}
            @if ($error && !$loading)
                <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6 max-w-2xl mx-auto">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-700 font-medium">{{ $error }}</p>
                    </div>
                </div>
            @endif

            {{-- Video Cards Grid --}}
            @if (!$loading && count($videos) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                    @foreach ($videos as $video)
                        @php
                            // Extract video data from API response
                            $videoId = $video['aweme_id'] ?? ($video['video_id'] ?? '');
                            $videoTitle = $video['title'] ?? 'TikTok Video';
                            $desc = $video['desc'] ?? ($video['title'] ?? 'TikTok Video');
                            $createTime = $video['create_time'] ?? time();

                            // Video cover/thumbnail
                            $cover =
                                $video['video']['cover'] ??
                                ($video['video']['origin_cover'] ??
                                    ($video['video']['dynamic_cover'] ?? ($video['cover'] ?? '')));

                            // Statistics
                            $playCount =
                                $video['play_count'] ??
                                ($video['statistics']['play_count'] ??
                                    ($video['stats']['play_count'] ??
                                        ($video['statistics']['playCount'] ?? ($video['stats']['playCount'] ?? 0))));
                            $diggCount = $video['digg_count'] ?? ($video['diggCount'] ?? 0);
                            $commentCount = $video['comment_count'] ?? ($video['commentCount'] ?? 0);

                            // Author/User info
                            $author = $video['author'] ?? [];
                            $authorName = $author['nickname'] ?? ($author['nick_name'] ?? $username);
                            $authorAvatar =
                                $author['avatar_larger'] ??
                                ($author['avatar_medium'] ?? ($author['avatar_thumb'] ?? ($author['avatar'] ?? '')));

                            // Fallback avatar if none exists
                            if (empty($authorAvatar)) {
                                $authorAvatar =
                                    'https://ui-avatars.com/api/?name=' .
                                    urlencode($authorName) .
                                    '&size=200&background=667eea&color=fff';
                            }

                            // Get play URL
                            $playUrl =
                                $video['video']['play_addr']['url_list'][0] ??
                                ($video['video']['play'] ?? ($video['video']['play_addr'] ?? ($video['play'] ?? '')));

                            // Extract hashtags
                            $hashtags = [];
                            if (isset($video['text_extra']) && is_array($video['text_extra'])) {
                                foreach ($video['text_extra'] as $extra) {
                                    if (isset($extra['hashtag_name'])) {
                                        $hashtags[] = '#' . $extra['hashtag_name'];
                                    }
                                }
                            }
                            // Limit to 3 hashtags
                            $hashtags = array_slice($hashtags, 0, 3);
                        @endphp

                        <div x-data="{
                            playing: false,
                            playVideo() {
                                this.playing = true;
                                this.$nextTick(() => {
                                    const video = this.$refs.video;
                                    if (video) {
                                        document.querySelectorAll('video').forEach(v => {
                                            if (v !== video && !v.paused) {
                                                v.pause();
                                            }
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
                        }"
                            class="bg-bg-primary p-4 rounded-2xl shadow-md border border-second-500/40 overflow-hidden hover:shadow-xl transition-shadow">

                            {{-- Video Container --}}
                            <div class="relative w-full sm:h-80 lg:h-98 h-70 mb-2 rounded-lg overflow-hidden">
                                @if ($playUrl)
                                    {{-- Video Element (hidden until playing) --}}
                                    <video x-ref="video" x-show="playing" x-on:ended="stopVideo()"
                                        x-on:error="playing = false" class="w-full h-full object-cover"
                                        poster="{{ $cover }}" playsinline preload="metadata" controls
                                        controlsList="nodownload" x-cloak>
                                        <source src="{{ $playUrl }}" type="video/mp4">
                                    </video>

                                    {{-- Thumbnail (visible until video plays) --}}
                                    <div x-show="!playing" x-on:click="playVideo()"
                                        class="absolute inset-0 cursor-pointer">
                                        @if ($cover)
                                            <img src="{{ $cover }}" alt="{{ $desc }}"
                                                class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            <div
                                                class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-white" fill="currentColor"
                                                    viewBox="0 0 24 24">
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
                                                    <flux:icon name="play"
                                                        class="w-full h-full stroke-white/60 fill-white/50" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- No video available --}}
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                                        @if ($cover)
                                            <img src="{{ $cover }}" alt="{{ $desc }}"
                                                class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            <div class="flex flex-col items-center justify-center text-white">
                                                <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                                                </svg>
                                                <p class="text-sm">Video unavailable</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Video Info --}}
                            <div>
                                @if ($videoTitle)
                                    <p class="font-bold text-text-primary mb-1 line-clamp-1"
                                        title="{{ $videoTitle }}">
                                        {{ $videoTitle }}
                                    </p>
                                @else
                                    <p class="font-bold text-text-primary mb-1 line-clamp-1">
                                        {{ __('TikTok Video') }}
                                    </p>
                                @endif
                                <p class="text-xs text-text-secondary mb-4">{{ $authorName }}</p>

                                {{-- Stats --}}
                                <div class="flex items-center justify-evenly w-full gap-4 py-2 border-t border-b">
                                    {{-- Likes --}}
                                    <button class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                        <flux:icon name="heart" class="w-5 h-5 stroke-text-muted" />
                                        <span
                                            class="text-base text-text-muted">{{ $this->formatNumber($diggCount) }}</span>
                                    </button>

                                    {{-- Comments --}}
                                    <button class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                        <flux:icon name="chat-bubble-oval-left" class="w-5 h-5" />
                                        <span
                                            class="text-base text-text-muted">{{ $this->formatNumber($commentCount) }}</span>
                                    </button>

                                    {{-- Views --}}
                                    <button class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                        <flux:icon name="eye" class="w-5 h-5" />
                                        <span
                                            class="text-base text-text-muted">{{ $this->formatNumber($playCount) }}</span>
                                    </button>
                                </div>

                                {{-- Hashtags --}}
                                @if (!empty($hashtags))
                                    <div class="flex flex-wrap gap-2 sm:gap-3 mt-3">
                                        @foreach ($hashtags as $tag)
                                            <span
                                                class="text-xs sm:text-sm text-second-500 font-medium">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination - Show if needed --}}
                @if ($this->shouldShowPagination())
                    <div class="mt-12 px-4">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 rounded-2xl">

                            {{-- Page Info - Left Side (Always Visible) --}}
                            <div class="text-sm font-inter">
                                <span class="text-gray-600">{{ __('Page') }}</span>
                                <span
                                    class="mx-1 px-2.5 py-1 rounded-lg bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold text-base shadow-md">
                                    {{ $currentPage }}
                                </span>
                                @if ($this->getTotalPages() > $currentPage)
                                    <span class="text-gray-600">{{ __('of') }}</span>
                                    <span class="ml-1 font-semibold text-gray-800">{{ $this->getTotalPages() }}</span>
                                @endif
                            </div>

                            {{--  --}} 
                            <div class="flex items-center gap-3">
                                {{-- Pagination Controls - Hidden During Loading --}}
                                <div wire:loading.remove wire:target="nextPage,previousPage,goToPage"
                                    class="flex items-center gap-3">

                                    {{-- Previous Button --}}
                                    <button wire:click="previousPage" wire:loading.attr="disabled"
                                        @if (!$this->hasPreviousPage()) disabled @endif
                                        class="group relative px-5 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-2 shadow-md hover:shadow-xl hover:scale-105 disabled:hover:scale-100">
                                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                        <span class="hidden sm:inline">{{ __('Previous') }}</span>
                                    </button>

                                    {{-- Page Numbers (for desktop) --}}
                                    <div class="hidden md:flex items-center gap-2">
                                        @php
                                            $totalPages = $this->getTotalPages();
                                            $start = max(1, $currentPage - 2);
                                            $end = min($totalPages, $currentPage + 2);
                                        @endphp

                                        @if ($start > 1)
                                            <button wire:click="goToPage(1)"
                                                class="px-4 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105">
                                                1
                                            </button>
                                            @if ($start > 2)
                                                <span class="px-2 text-gray-400 font-bold">...</span>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            <button wire:click="goToPage({{ $i }})"
                                                wire:loading.attr="disabled"
                                                class="px-4 py-2.5 rounded-xl border-2 transition-all duration-300 font-semibold shadow-md hover:shadow-lg hover:scale-105
                                {{ $i === $currentPage
                                    ? 'bg-gradient-to-r from-second-500 to-zinc-500 text-white border-transparent ring-2 ring-second-300'
                                    : 'border-second-500/40 bg-white hover:bg-second-50 text-gray-700' }}">
                                                {{ $i }}
                                            </button>
                                        @endfor

                                        @if ($end < $totalPages)
                                            @if ($end < $totalPages - 1)
                                                <span class="px-2 text-gray-400 font-bold">...</span>
                                            @endif
                                            <button wire:click="goToPage({{ $totalPages }})"
                                                class="px-4 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105">
                                                {{ $totalPages }}
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Current Page (for mobile) --}}
                                    <div
                                        class="md:hidden px-5 py-2.5 rounded-xl bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold shadow-lg ring-2 ring-second-300">
                                        {{ $currentPage }}
                                    </div>

                                    {{-- Next Button --}}
                                    <button wire:click="nextPage" wire:loading.attr="disabled"
                                        @if (!$this->hasNextPage()) disabled @endif
                                        class="group relative px-5 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-2 shadow-md hover:shadow-xl hover:scale-105 disabled:hover:scale-100">
                                        <span class="hidden sm:inline">{{ __('Next') }}</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Loading State - Only on Right Side --}}
                                <div wire:loading wire:target="nextPage,previousPage,goToPage"
                                    class="flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg border border-gray-200/50">
                                    <div class="relative">
                                        {{-- Animated spinner rings --}}
                                        <div class="w-10 h-10 rounded-full border-3 border-gray-200"></div>
                                        <div
                                            class="absolute top-0 left-0 w-10 h-10 rounded-full border-3 border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                        </div>
                                        <div class="absolute top-0 left-0 w-10 h-10 rounded-full border-3 border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                            style="animation-direction: reverse; animation-duration: 1s;"></div>
                                    </div>
                                    <span
                                        class="text-sm font-semibold text-gray-700 animate-pulse">{{ __('Loading...') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Empty State --}}
            @if (!$loading && count($videos) == 0 && !$error)
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ __('No videos available') }}</h3>
                    <p class="text-gray-600">
                        {{ __('No videos found for this user') }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // Scroll to video section when page changes
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('scroll-to-user-videos', () => {
                    const section = document.getElementById('user-video-section');
                    if (section) {
                        section.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
    @endpush

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
