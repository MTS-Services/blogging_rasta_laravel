<div>
    <section class="bg-gradient">
        {{-- Banner Section --}}
        <div class="container pt-20 pb-16 lg:pt-24">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                {{-- Text Content --}}
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    {{-- Small Badge --}}
                    <div class="inline-flex items-center bg-second-500/40 rounded-full py-2 px-4 mb-4">
                        <flux:icon name="sun" class="w-5 h-5 mr-2 text-second-500" />
                        <span class="text-xs text-text-muted font-inter">
                            {{ __('Trusted by 50K+ beauty lovers') }}
                        </span>
                    </div>

                    {{-- Heading --}}

                    <h2
                        class="text-5xl md:text-7xl lg:text-8xl font-semibold font-montserrat text-second-800 mb-6 text-zinc-900">
                        {{ (app()->getLocale() === 'en' ? $banner->title_en : $banner->title_fr) ?? __('Discover routines that actually work') }}
                    </h2>
                    {{-- <h2
                        class="text-5xl md:text-7xl lg:text-8xl font-semibold font-montserrat text-second-800 mb-6 text-zinc-900">
                        {{ __('Glow') }}</h2>

                    <h2
                        class="font-semibold font-montserrat text-second-800 mb-6 wrap-break-word
                        @if (session('locale') === 'fr') text-4xl
                            md:text-6xl
                            lg:text-7xl
                        @else
                            text-5xl
                            md:text-7xl
                            lg:text-8xl @endif
                        ">
                        {{ __('Naturally') }}
                    </h2> --}}

                    {{-- Description --}}
                    <p class="text-lg md:text-xl text-text-primary font-medium font-inter max-w-lg mx-auto lg:mx-0">
                        {{ (app()->getLocale() === 'en' ? $banner->description_en : $banner->description_fr) ?? __('Discover routines that actually work. Explore trending videos, shop vetted products, and get personalized advice tailored to your skin type.') }}
                    </p>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 mt-8">
                        <x-ui.button href="{{ 'product' }}"
                            class="py-4 px-8 bg-lradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                            <span class="text-white">{{ __('Discover Your Glow') }}</span>
                            <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                        </x-ui.button>

                        <x-ui.button href="{{ 'video-feed' }}" variant="secondary"
                            class="py-4 px-8 border border-second-500 group transition-all duration-300">
                            <flux:icon name="play"
                                class="w-4 h-4 stroke-text-primary group-hover:stroke-white transition-colors" />
                            <span class="text-text-primary group-hover:text-white transition-colors">
                                {{ __('Watch Stories') }}
                            </span>
                        </x-ui.button>
                    </div>
                </div>

                <!-- Banner Video Section -->
                <div class="w-full lg:w-1/2 flex justify-center relative">
                    @if ($banner && $banner->banner_video)
                        <!-- Video Container -->
                        <div class="relative w-full max-w-[500px] lg:max-w-none">
                            <!-- Video Element with Controls (Fixed Height for Matching Thumbnail) -->
                            {{-- poster="{{ asset('storage/' . $banner->thumbnail) }}" --}}
                            <video id="bannerVideo" controls
                                class="w-full h-[500px] lg:h-[600px] rounded-lg object-cover block">
                                <source src="{{ asset('storage/' . $banner->banner_video) }}" type="video/mp4">
                                {{ __('Your browser video support is not enough.') }}
                            </video>

                            <!-- Custom Play Button Overlay -->
                            <div id="playButton"
                                class="absolute inset-0 flex items-center justify-center cursor-pointer pointer-events-none">
                                <!-- Play Button Box (White Background) -->
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-xl pointer-events-auto"
                                    onclick="document.getElementById('bannerVideo').play();">
                                    <!-- Play Icon (Color: #D09003) -->
                                    <svg class="w-10 h-10 ml-1" fill="#D09003" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @else
                        <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="Banner image"
                            class="w-full max-w-[500px] lg:max-w-none h-auto rounded-lg object-cover block">
                    @endif
                </div>
                {{-- <div class="w-full lg:w-1/2 flex justify-center">
                    <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="Banner image"
                        class="w-full max-w-[500px] lg:max-w-none h-auto rounded-lg object-cover block">
                </div> --}}
            </div>

            {{-- Stats Section --}}
            <div class="flex flex-wrap justify-center lg:justify-start gap-10 mt-16">
                <div class="text-center lg:text-left">
                    <h3 class="text-4xl md:text-5xl font-playfair text-second-800 mb-1">{{ __('50K+') }}</h3>
                    <p class="text-base font-inter text-text-primary">{{ __('Followers') }}</p>
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-4xl md:text-5xl font-playfair text-zinc-500 mb-1">{{ __('100+') }}</h3>
                    <p class="text-base font-inter text-text-primary">{{ __('Products Curated') }}</p>
                </div>
                <div class="text-center lg:text-left">
                    <h3 class="text-4xl md:text-5xl font-playfair text-second-800 mb-1">{{ __('95%') }}</h3>
                    <p class="text-base font-inter text-text-primary">{{ __('Satisfaction') }}</p>
                </div>
            </div>
        </div>
    </section>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <section>
        <div class="bg-bg-primary" id="video-section">
            {{-- Featured TikTok Clips Section --}}
            <div class="container py-20 lg:py-24">
                {{-- Header --}}
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary">
                        {{ __('Featured TikTok Clips') }}
                    </h2>
                    <p class="text-base md:text-lg text-text-primary font-semibold font-inter mt-4">
                        {{ __('The latest viral skincare trends everyone\'s talking about') }}
                    </p>
                </div>

                {{-- Loading State --}}
                @if ($loading)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 mt-12 px-4">
                        @for ($i = 0; $i < 12; $i++)
                            <div class="animate-pulse">
                                <div class="bg-gray-300 aspect-[1/1.1] rounded-2xl"></div>
                                <div class="flex items-center gap-3 mt-3">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
                                    <div class="flex-1">
                                        <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                @endif

                {{-- Error State --}}
                @if ($error && !$loading)
                    <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6 mt-12 max-w-2xl mx-auto">
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

                {{-- Video Grid --}}
                @if (!$loading && count($featuredVideos) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 mt-12 px-4">
                        @foreach ($featuredVideos as $video)
                            @php
                                // Extract video data
                                $videoId = $video['aweme_id'] ?? ($video['video_id'] ?? '');
                                $title = $video['title'] ?: 'TikTok Video';
                                $cover = $video['cover'] ?? ($video['origin_cover'] ?? '');
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
                                    'https://ui-avatars.com/api/?name=' .
                                        urlencode($authorName) .
                                        '&size=200&background=667eea&color=fff';
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
                                        <video x-ref="video" x-show="playing" x-on:ended="stopVideo()"
                                            x-on:error="playing = false" class="w-full h-full object-cover"
                                            poster="{{ $cover }}" playsinline preload="metadata" controls
                                            controlsList="nodownload" x-cloak>
                                            <source src="{{ $playUrl }}" type="video/mp4">
                                        </video>

                                        {{-- Thumbnail --}}
                                        <div x-show="!playing" x-on:click="playVideo()"
                                            class="absolute inset-0 cursor-pointer">
                                            @if ($cover)
                                                <img src="{{ $cover }}" alt="{{ $title }}"
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
                                                <div
                                                    class="transform hover:scale-110 transition-transform duration-300">
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
                                            class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-500 flex flex-col items-center justify-center text-white">
                                            <svg class="w-16 h-16 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                                            </svg>
                                            <p class="text-sm">Video unavailable</p>
                                        </div>
                                    @endif
                                </div>
                                {{-- Creator Info --}}
                                <a href="{{ route('video.details', $video['video_id']) }}" wire:navigate>
                                    <div class="flex items-center gap-3 mt-3">
                                        <div class="w-10 h-10 flex-shrink-0">
                                            <img src="{{ $authorAvatar }}" alt="{{ $authorName }}"
                                                class="w-full h-full rounded-full object-cover border-2 border-purple-500"
                                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($authorName) }}&size=200&background=667eea&color=fff'">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h6 class="text-text-primary font-semibold font-inter truncate"
                                                title="{{ $title }}">
                                                {{ $title }}
                                            </h6>
                                            <p class="text-sm font-normal text-text-primary font-outfit truncate"
                                                title="{{ $authorName }}">
                                                {{ $authorName }}
                                            </p>
                                            <div class="flex items-center gap-3 text-xs text-text-muted mt-0.5">
                                                @if ($playCount > 0)
                                                    <span>{{ $this->formatNumber($playCount) }}
                                                        {{ __('views') }}</span>
                                                @endif
                                                @if ($diggCount > 0)
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $this->formatNumber($diggCount) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    {{-- Pagination --}}
                    @if ($this->shouldShowPagination())
                        <div class="mt-8 sm:mt-12 px-2 sm:px-4">
                            <div
                                class="flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-3 sm:gap-4 p-3 sm:p-6 rounded-xl sm:rounded-2xl">

                                {{-- Page Info - Left Side (Hidden on Mobile) --}}
                                <div class="hidden sm:flex text-sm font-inter">
                                    <span class="text-gray-600">{{ __('Page') }}</span>
                                    <span
                                        class="mx-1 px-2.5 py-1 rounded-lg bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold text-base shadow-md">
                                        {{ $currentPage }}
                                    </span>
                                    @if ($this->getTotalPages() > $currentPage)
                                        <span class="text-gray-600">{{ __('of') }}</span>
                                        <span
                                            class="ml-1 font-semibold text-gray-800">{{ $this->getTotalPages() }}</span>
                                    @endif
                                </div>

                                {{-- Right Side Controls --}}
                                <div class="flex items-center gap-2 sm:gap-3">

                                    {{-- Previous Button --}}
                                    <button wire:click="previousPage" wire:loading.attr="disabled"
                                        wire:target="previousPage" @if (!$this->hasPreviousPage()) disabled @endif
                                        class="group relative px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-1 sm:gap-2 shadow-sm sm:shadow-md hover:shadow-lg sm:hover:shadow-xl hover:scale-105 disabled:hover:scale-100">

                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 transition-transform group-hover:-translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>

                                        <span wire:loading.remove wire:target="previousPage"
                                            class="hidden sm:inline">{{ __('Previous') }}</span>
                                        <span wire:loading wire:target="previousPage" class="hidden sm:inline">
                                            <div class="relative">
                                                {{-- Animated spinner rings --}}
                                                <div class="w-6 h-6  rounded-full border border-gray-200">
                                                </div>
                                                <div
                                                    class="absolute top-0 left-0 w-6 h-6  rounded-full border  border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                </div>
                                                <div class="absolute top-0 left-0 w-6 h-6  rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                    style="animation-direction: reverse; animation-duration: 1s;">
                                                </div>
                                            </div>
                                        </span>
                                    </button>

                                    {{-- Page Numbers --}}
                                    <div class="hidden md:flex items-center gap-1.5 sm:gap-2">
                                        @php
                                            $totalPages = $this->getTotalPages();
                                            $start = max(1, $currentPage - 2);
                                            $end = min($totalPages, $currentPage + 2);
                                        @endphp

                                        @if ($start > 1)
                                            <button wire:click="goToPage(1)" wire:loading.attr="disabled"
                                                wire:target="goToPage(1)"
                                                class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-sm sm:shadow-md hover:shadow-lg hover:scale-105 text-sm sm:text-base">
                                                <span wire:loading.remove wire:target="goToPage(1)">1</span>
                                                <span wire:loading wire:target="goToPage(1)">
                                                    <div class="relative">
                                                        {{-- Animated spinner rings --}}
                                                        <div class="w-6 h-6  rounded-full border border-gray-200">
                                                        </div>
                                                        <div
                                                            class="absolute top-0 left-0 w-6 h-6  rounded-full border  border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                        </div>
                                                        <div class="absolute top-0 left-0 w-6 h-6  rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                            style="animation-direction: reverse; animation-duration: 1s;">
                                                        </div>
                                                    </div>
                                                </span>
                                            </button>
                                            @if ($start > 2)
                                                <span
                                                    class="px-1 sm:px-2 text-gray-400 font-bold text-sm sm:text-base">...</span>
                                            @endif
                                        @endif

                                        @for ($i = $start; $i <= $end; $i++)
                                            <button wire:click="goToPage({{ $i }})"
                                                wire:loading.attr="disabled"
                                                wire:target="goToPage({{ $i }})"
                                                class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border-2 transition-all duration-300 font-semibold shadow-sm sm:shadow-md hover:shadow-lg hover:scale-105 text-sm sm:text-base
                                {{ $i === $currentPage
                                    ? 'bg-gradient-to-r from-second-500 to-zinc-500 text-white border-transparent ring-2 ring-second-300'
                                    : 'border-second-500/40 bg-white hover:bg-second-50 text-gray-700' }}">

                                                <span wire:loading.remove
                                                    wire:target="goToPage({{ $i }})">{{ $i }}</span>
                                                <span wire:loading wire:target="goToPage({{ $i }})">
                                                    <div class="relative">
                                                        {{-- Animated spinner rings --}}
                                                        <div class="w-6 h-6  rounded-full border border-gray-200">
                                                        </div>
                                                        <div
                                                            class="absolute top-0 left-0 w-6 h-6  rounded-full border  border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                        </div>
                                                        <div class="absolute top-0 left-0 w-6 h-6  rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                            style="animation-direction: reverse; animation-duration: 1s;">
                                                        </div>
                                                    </div>
                                                </span>
                                            </button>
                                        @endfor

                                        @if ($end < $totalPages)
                                            @if ($end < $totalPages - 1)
                                                <span
                                                    class="px-1 sm:px-2 text-gray-400 font-bold text-sm sm:text-base">...</span>
                                            @endif
                                            <button wire:click="goToPage({{ $totalPages }})"
                                                wire:loading.attr="disabled"
                                                wire:target="goToPage({{ $totalPages }})"
                                                class="px-3 py-2 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-sm sm:shadow-md hover:shadow-lg hover:scale-105 text-sm sm:text-base">
                                                <span wire:loading.remove
                                                    wire:target="goToPage({{ $totalPages }})">{{ $totalPages }}</span>
                                                <span wire:loading wire:target="goToPage({{ $totalPages }})">
                                                    <div class="relative">
                                                        {{-- Animated spinner rings --}}
                                                        <div class="w-6 h-6  rounded-full border border-gray-200">
                                                        </div>
                                                        <div
                                                            class="absolute top-0 left-0 w-6 h-6  rounded-full border  border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                        </div>
                                                        <div class="absolute top-0 left-0 w-6 h-6  rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                            style="animation-direction: reverse; animation-duration: 1s;">
                                                        </div>
                                                    </div>
                                                </span>
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Current Page (Mobile) --}}
                                    <div
                                        class="md:hidden px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold shadow-md sm:shadow-lg ring-2 ring-second-300 text-sm sm:text-base">
                                        {{ $currentPage }}
                                    </div>

                                    {{-- Next Button --}}
                                    <button wire:click="nextPage" wire:loading.attr="disabled" wire:target="nextPage"
                                        @if (!$this->hasNextPage()) disabled @endif
                                        class="group relative px-3 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-1 sm:gap-2 shadow-sm sm:shadow-md hover:shadow-lg sm:hover:shadow-xl hover:scale-105 disabled:hover:scale-100">

                                        <span wire:loading.remove wire:target="nextPage"
                                            class="hidden sm:inline">{{ __('Next') }}</span>
                                        <span wire:loading wire:target="nextPage" class="hidden sm:inline">
                                            <div class="relative">
                                                {{-- Animated spinner rings --}}
                                                <div class="w-6 h-6  rounded-full border border-gray-200">
                                                </div>
                                                <div
                                                    class="absolute top-0 left-0 w-6 h-6  rounded-full border  border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                </div>
                                                <div class="absolute top-0 left-0 w-6 h-6  rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                    style="animation-direction: reverse; animation-duration: 1s;">
                                                </div>
                                            </div>
                                        </span>

                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 transition-transform group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                </div>
                            </div>
                        </div>
                    @endif

                @endif

                {{-- Empty State --}}
                @if (!$loading && count($featuredVideos) == 0 && !$error)
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ __('No videos available') }}</h3>
                        <p class="text-gray-600">{{ __('Check back soon for new content') }}</p>
                    </div>
                @endif
            </div>
        </div>

        @push('scripts')
            <script>
                // Scroll to video section when page changes
                document.addEventListener('livewire:initialized', () => {
                    Livewire.on('scroll-to-videos', () => {
                        const section = document.getElementById('video-section');
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
    </section>
    <section class="bg-bg-secondary">
        {{-- Trending Hashtags --}}
        <div class="container py-20 lg:py-24 px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary mb-3">
                    {{ __('Trending Hashtags') }}
                </h2>
                <p class="text-base md:text-lg text-text-primary font-semibold font-inter">
                    {{ __('Join the conversation with beauty lovers worldwide') }}
                </p>
            </div>

            {{-- Hashtag Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($keywords as $keyword)
                    <div
                        class="bg-white border border-second-500/30 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                        <h3 class="text-2xl font-medium font-montserrat text-text-primary mb-1">
                            #{{ $keyword->name }}
                        </h3>
                        <span class="text-sm text-text-muted">
                            {{ $keyword->video_keywords_count ?? 0 }} {{ __('videos') }}
                        </span>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-text-muted">{{ __('No trending hashtags available') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-second-200">
        {{-- Routine Section --}}
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary mb-4">
                {{ __('Ready to Find Your Perfect Routine?') }}
            </h2>
            <p class="text-base md:text-lg text-text-primary font-normal font-inter max-w-3xl mx-auto mb-8">
                {{ __('Discover routines tailored to your lifestyle. From skincare and fitness to productivity and wellness, our tips and guides help you build habits that stick — making everyday life simpler, healthier, and more enjoyable. Start your journey today!') }}
            </p>

            {{-- CTA Button --}}
            <div class="w-fit mx-auto">
                <x-ui.button href="{{ route('product') }}"
                    class="py-4 px-8 bg-gradient-to-r from-second-500 to-zinc-500 hover:shadow-lg transition-all duration-300">
                    <span class="text-white">{{ __('Discover Your Glow') }}</span>
                    <flux:icon name="arrow-right" class="w-4 h-4 stroke-white" />
                </x-ui.button>
            </div>

            <p class="text-sm md:text-base font-normal font-inter text-text-muted mt-6">
                {{ __('It only takes 2 minutes. No signup required.') }}
            </p>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const video = document.getElementById('bannerVideo');
                const playButton = document.getElementById('playButton');

                // Video play হলে custom button hide করবে
                video.addEventListener('play', function() {
                    playButton.style.display = 'none';
                });

                // Video pause হলে custom button আবার show করবে
                video.addEventListener('pause', function() {
                    if (video.currentTime > 0 && !video.ended) {
                        playButton.style.display = 'flex';
                    }
                });

                // Video শেষ হলে custom button আবার show করবে
                video.addEventListener('ended', function() {
                    playButton.style.display = 'flex';
                });
            });
        </script>
    @endpush
</div>
