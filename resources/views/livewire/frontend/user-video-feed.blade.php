<div class="min-h-screen bg-bg-primary py-8 sm:py-12 px-4">
    <div class="container mx-auto">
        <div id="user-video-section">
            {{-- Header with Back Button and User Info --}}
            <div class="mb-5 xl:mb-8 mx-auto max-w-xl">
                {{-- <a href="{{ route('video-feed') }}" wire:navigate
                    class="inline-flex items-center gap-2 text-second-500 hover:text-second-600 mb-4 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="font-medium">{{ __('Back to All Videos') }}</span>
                </a> --}}

                <h1 class="text-2xl sm:text-3xl md:text-4xl xl:text-5xl font-bold text-text-primary mb-1.5 sm:mb-3">
                    {{ $displayName }}
                </h1>
                <p class="text-text-secondary text-base">
                    {{ __('Videos from @') }}{{ $username }}
                </p>
            </div>

            {{-- Filter Tabs (User-based) --}}
            <div class="flex flex-wrap gap-1 sm:gap-2 mb-5 xl:mb-10 mx-auto">
                @foreach ($this->users as $name => $username)
                    @if ($username === 'All')
                        <a href="{{ route('video-feed') }}" wire:navigate
                            class="px-1.5 sm:px-3 py-2 rounded-lg font-inter text-xs sm:text-sm font-medium transition-colors
                            {{ $username === $username
                                ? 'bg-second-500 text-white'
                                : 'bg-second-800/10 text-second-500 hover:bg-second-400/40' }}">
                            {{ $name }}
                        </a>
                    @else
                        @php
                            // Find actual username for this display name
                            $featuredUsers = config('tiktok.featured_users', []);
                            $userData = collect($featuredUsers)->firstWhere('username', $username);
                            $actualUsername = $userData['username'];
                        @endphp
                        <a href="{{ route('user-video-feed', ['username' => $actualUsername]) }}" wire:navigate
                            class="px-1.5 sm:px-3 py-2 rounded-lg font-inter text-xs sm:text-sm font-medium transition-colors
                             {{ $actualUsername === $username
                                 ? 'bg-second-500 text-white'
                                 : 'bg-second-800/10 text-second-500 hover:bg-second-400/40' }}">
                            {{ $name }}
                        </a>
                    @endif
                @endforeach
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
                            $videoId = $video['video_id'];
                            $videoTitle = $video['title'] ?? 'TikTok Video';
                            $desc = $video['desc'] ?? ($video['title'] ?? 'TikTok Video');
                            $createTime = $video['create_time'] ?? time();
                            $tiktokUrl = $this->getTikTokUrl($video->username, $videoId) ?? '#';

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
                            $shareCount = $video['share_count'] ?? ($video['shareCount'] ?? 0);

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
                            $escapedTitle = addslashes($videoTitle);
                            $escapedDesc = addslashes($desc);
                        @endphp

                        <div x-data="{
                            playing: false,
                            showShareMenu: false,
                            tiktokUrl: '{{ $this->getTikTokUrl($video->username, $video->video_id) }}',
                            videoTitle: '{{ $escapedTitle }}',
                            videoDesc: '{{ $escapedDesc }}',

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
                            },

                            openOnTikTok() {
                                window.open(this.tiktokUrl, '_blank');
                                this.showShareMenu = false;
                            },

                            shareToWhatsApp() {
                                const text = encodeURIComponent(this.videoTitle + '\n' + this.tiktokUrl);
                                window.open('https://wa.me/?text=' + text, '_blank');
                                this.showShareMenu = false;
                            },

                            shareToFacebook() {
                                const url = encodeURIComponent(this.tiktokUrl);
                                window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank', 'width=600,height=400');
                                this.showShareMenu = false;
                            },

                            shareToMessenger() {
                                const url = encodeURIComponent(this.tiktokUrl);
                                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                                if (isMobile) {
                                    window.open('fb-messenger://share/?link=' + url, '_blank');
                                } else {
                                    window.open('https://www.facebook.com/dialog/send?link=' + url + '&app_id=YOUR_APP_ID&redirect_uri=' + url, '_blank');
                                }
                                this.showShareMenu = false;
                            },

                            shareToTwitter() {
                                const text = encodeURIComponent(this.videoTitle);
                                const url = encodeURIComponent(this.tiktokUrl);
                                window.open('https://twitter.com/intent/tweet?text=' + text + '&url=' + url, '_blank', 'width=600,height=400');
                                this.showShareMenu = false;
                            },

                            copyLink() {
                                navigator.clipboard.writeText(this.tiktokUrl).then(() => {
                                    alert('Link copied to clipboard!');
                                    this.showShareMenu = false;
                                }).catch(err => {
                                    console.error('Failed to copy:', err);
                                    alert('Failed to copy link. Please try again.');
                                });
                            }
                        }" @click.away="showShareMenu = false"
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
                                <a href="{{ route('video.details', $videoId) }}" class="block mb-2" wire:navigate>
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
                                </a>

                                <div class="flex items-center justify-evenly w-full gap-4 py-2 border-t border-b">
                                    <button class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                        <flux:icon name="heart" class="w-5 h-5 stroke-text-muted" />
                                        <span
                                            class="text-base text-text-muted">{{ $this->formatNumber($diggCount) }}</span>
                                    </button>

                                    <button class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                        <flux:icon name="chat-bubble-oval-left" class="w-5 h-5" />
                                        <span
                                            class="text-base text-text-muted">{{ $this->formatNumber($commentCount) }}</span>
                                    </button>

                                    <button class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                        <flux:icon name="eye" class="w-5 h-5" />
                                        <span
                                            class="text-base text-text-muted">{{ $this->formatNumber($playCount) }}</span>
                                    </button>

                                    {{-- Share Button --}}
                                    {{-- Replace the Share Button section in your user feed (around line 200) with this: --}}

                                    {{-- Share Button --}}
                                    <div class="relative">
                                        <button
                                            @click.stop="$dispatch('open-share-modal', {
                                                videoId: '{{ $videoId }}',
                                                title: '{{ $escapedTitle }}',
                                                description: '{{ $escapedDesc }}',
                                                cover: '{{ $cover }}',
                                                author: '{{ $authorName }}'
                                            })"
                                            class="flex items-center gap-1 text-scond-800/20 hover:text-second-500 transition-colors">
                                            <flux:icon name="share" class="w-5 h-5" />
                                            <span
                                                class="text-base text-text-muted">{{ $this->formatNumber($shareCount) }}</span>
                                        </button>

                                        {{-- Share Modal --}}
                                        <div x-data="{
                                            showModal: false,
                                            videoData: {},
                                            shareUrl: '',

                                            init() {
                                                this.$watch('showModal', value => {
                                                    document.body.style.overflow = value ? 'hidden' : 'auto';
                                                });

                                                window.addEventListener('open-share-modal', (event) => {
                                                    this.videoData = event.detail;
                                                    this.shareUrl = '{{ url('') }}/video/' + event.detail.videoId;
                                                    this.showModal = true;
                                                });
                                            },

                                            closeModal() {
                                                this.showModal = false;
                                            },

                                            shareVia(platform) {
                                                const url = encodeURIComponent(this.shareUrl);
                                                const title = encodeURIComponent(this.videoData.title);
                                                const description = encodeURIComponent(this.videoData.description);

                                                let shareUrl = '';

                                                switch (platform) {
                                                    case 'whatsapp':
                                                        shareUrl = `https://wa.me/?text=${title}%20${url}`;
                                                        break;
                                                    case 'facebook':
                                                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                                                        break;
                                                    case 'twitter':
                                                        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                                                        break;
                                                    case 'messenger':
                                                        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                                                        if (isMobile) {
                                                            shareUrl = `fb-messenger://share/?link=${url}`;
                                                        } else {
                                                            shareUrl = `https://www.facebook.com/dialog/send?link=${url}&redirect_uri=${url}`;
                                                        }
                                                        break;
                                                    case 'email':
                                                        shareUrl = `mailto:?subject=${title}&body=${description}%20${url}`;
                                                        break;
                                                }

                                                if (shareUrl) {
                                                    window.open(shareUrl, '_blank', 'width=600,height=400');
                                                }
                                            },

                                            copyLink() {
                                                navigator.clipboard.writeText(this.shareUrl).then(() => {
                                                    this.$refs.copySuccess.classList.remove('hidden');
                                                    setTimeout(() => {
                                                        this.$refs.copySuccess.classList.add('hidden');
                                                    }, 3000);
                                                }).catch(err => {
                                                    console.error('Failed to copy:', err);
                                                    alert('Failed to copy link. Please try again.');
                                                });
                                            }
                                        }" x-show="showModal"
                                            @keydown.escape.window="closeModal()"
                                            class="fixed inset-0 bg-black/50 opacity-30 z-50 flex items-center justify-center p-4"
                                            x-cloak style="display: none;">

                                            <div @click.away="closeModal()" x-show="showModal"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 transform scale-95"
                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                x-transition:leave-end="opacity-0 transform scale-95"
                                                class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl">

                                                {{-- Modal Header --}}
                                                <div class="flex items-center justify-between mb-6">
                                                    <h3 class="text-2xl font-bold font-montserrat text-text-primary">
                                                        {{ __('Share Video') }}
                                                    </h3>
                                                    <button @click="closeModal()"
                                                        class="text-gray-400 hover:text-gray-600 transition-colors">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                {{-- Video Preview --}}
                                                <div class="mb-6 p-4 bg-second-50 rounded-xl">
                                                    <div class="flex items-center gap-3">
                                                        <img :src="videoData.cover" :alt="videoData.title"
                                                            class="w-20 h-20 rounded-lg object-cover">
                                                        <div class="flex-1 min-w-0">
                                                            <p class="font-semibold text-text-primary font-inter truncate"
                                                                x-text="videoData.title"></p>
                                                            <p class="text-sm text-text-muted font-inter"
                                                                x-text="videoData.author"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Share Options --}}
                                                <div class="space-y-3 mb-6">
                                                    <p class="text-sm font-semibold text-text-primary font-inter mb-3">
                                                        {{ __('Share via:') }}
                                                    </p>

                                                    {{-- Social Media Buttons --}}
                                                    <div class="grid grid-cols-2 gap-3">
                                                        {{-- WhatsApp --}}
                                                        <button @click="shareVia('whatsapp')"
                                                            class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-colors">
                                                            <svg class="w-6 h-6 text-green-600" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                                            </svg>
                                                            <span class="font-semibold text-green-600">WhatsApp</span>
                                                        </button>

                                                        {{-- Facebook --}}
                                                        <button @click="shareVia('facebook')"
                                                            class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                            </svg>
                                                            <span class="font-semibold text-blue-600">Facebook</span>
                                                        </button>

                                                        {{-- Twitter --}}
                                                        <button @click="shareVia('twitter')"
                                                            class="flex items-center gap-3 p-3 bg-sky-50 hover:bg-sky-100 rounded-xl transition-colors">
                                                            <svg class="w-6 h-6 text-sky-600" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                                            </svg>
                                                            <span class="font-semibold text-sky-600">Twitter</span>
                                                        </button>

                                                        {{-- Messenger --}}
                                                        <button @click="shareVia('messenger')"
                                                            class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                                                            <svg class="w-6 h-6 text-blue-500" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M12 0C5.373 0 0 4.974 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.963 3.26L10.732 8l3.131 3.259L19.752 8l-6.561 6.963z" />
                                                            </svg>
                                                            <span class="font-semibold text-blue-500">Messenger</span>
                                                        </button>
                                                    </div>

                                                    {{-- Email Button --}}
                                                    <button @click="shareVia('email')"
                                                        class="w-full flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                                                        <svg class="w-6 h-6 text-gray-600" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                            <path
                                                                d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                                        </svg>
                                                        <span class="font-semibold text-gray-600">Email</span>
                                                    </button>
                                                </div>

                                                {{-- Copy Link Section --}}
                                                <div class="space-y-3">
                                                    <p class="text-sm font-semibold text-text-primary font-inter">
                                                        {{ __('Or copy link:') }}
                                                    </p>
                                                    <div class="flex gap-2">
                                                        <input type="text" x-model="shareUrl" readonly
                                                            class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl font-inter text-sm text-text-primary focus:outline-none focus:border-second-500">
                                                        <button @click="copyLink()"
                                                            class="px-6 py-3 bg-gradient-to-r from-second-500 to-zinc-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="hidden sm:inline">{{ __('Copy') }}</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Success Message --}}
                                                <div x-ref="copySuccess"
                                                    class="hidden mt-3 p-3 bg-green-50 text-green-700 rounded-xl text-sm font-inter text-center">
                                                    ✓ {{ __('Link copied to clipboard!') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hashtags --}}
                                @if (!empty($video['videoKeywords']))
                                    <div class="flex flex-wrap gap-2 sm:gap-3 mt-3">
                                        @foreach ($video['videoKeywords'] as $keyword)
                                            <span
                                                class="text-xs sm:text-sm text-second-500 lowercase font-medium">#{{ $keyword }}</span>
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
                            <div class="hidden sm:flex text-sm font-inter">
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

                            {{-- Right Side Controls --}}
                            <div class="flex items-center gap-3">

                                {{-- Previous Button --}}
                                <button wire:click="previousPage" wire:loading.attr="disabled"
                                    wire:target="previousPage" @if (!$this->hasPreviousPage()) disabled @endif
                                    class="group relative px-5 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-2 shadow-md hover:shadow-xl hover:scale-105 disabled:hover:scale-100">

                                    <svg wire:loading.remove wire:target="previousPage"
                                        class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>

                                    <span wire:loading wire:target="previousPage" class="flex items-center">
                                        <div class="relative w-5 h-5">
                                            <div class="w-5 h-5 rounded-full border border-gray-200"></div>
                                            <div
                                                class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                            </div>
                                            <div class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                style="animation-direction: reverse; animation-duration: 1s;"></div>
                                        </div>
                                    </span>

                                    <span wire:loading.remove wire:target="previousPage"
                                        class="hidden sm:inline">{{ __('Previous') }}</span>
                                </button>

                                {{-- Page Numbers (for desktop) --}}
                                <div class="hidden md:flex items-center gap-2">
                                    @php
                                        $totalPages = $this->getTotalPages();
                                        $start = max(1, $currentPage - 2);
                                        $end = min($totalPages, $currentPage + 2);
                                    @endphp

                                    @if ($start > 1)
                                        <button wire:click="goToPage(1)" wire:loading.attr="disabled"
                                            wire:target="goToPage(1)"
                                            class="px-4 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 flex items-center justify-center min-w-[3rem]">

                                            <span wire:loading wire:target="goToPage(1)" class="flex items-center">
                                                <div class="relative w-5 h-5">
                                                    <div class="w-5 h-5 rounded-full border border-gray-200"></div>
                                                    <div
                                                        class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                    </div>
                                                    <div class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                        style="animation-direction: reverse; animation-duration: 1s;">
                                                    </div>
                                                </div>
                                            </span>

                                            <span wire:loading.remove wire:target="goToPage(1)">1</span>
                                        </button>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-400 font-bold">...</span>
                                        @endif
                                    @endif

                                    @for ($i = $start; $i <= $end; $i++)
                                        <button wire:click="goToPage({{ $i }})"
                                            wire:loading.attr="disabled" wire:target="goToPage({{ $i }})"
                                            class="px-4 py-2.5 rounded-xl border-2 transition-all duration-300 font-semibold shadow-md hover:shadow-lg hover:scale-105 flex items-center justify-center min-w-[3rem]
                            {{ $i === $currentPage ? 'bg-gradient-to-r from-second-500 to-zinc-500 text-white border-transparent ring-2 ring-second-300' : 'border-second-500/40 bg-white hover:bg-second-50 text-gray-700' }}">

                                            <span wire:loading wire:target="goToPage({{ $i }})"
                                                class="flex items-center">
                                                <div class="relative w-5 h-5">
                                                    <div class="w-5 h-5 rounded-full border border-gray-200"></div>
                                                    <div
                                                        class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                    </div>
                                                    <div class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                        style="animation-direction: reverse; animation-duration: 1s;">
                                                    </div>
                                                </div>
                                            </span>

                                            <span wire:loading.remove
                                                wire:target="goToPage({{ $i }})">{{ $i }}</span>
                                        </button>
                                    @endfor

                                    @if ($end < $totalPages)
                                        @if ($end < $totalPages - 1)
                                            <span class="px-2 text-gray-400 font-bold">...</span>
                                        @endif
                                        <button wire:click="goToPage({{ $totalPages }})"
                                            wire:loading.attr="disabled" wire:target="goToPage({{ $totalPages }})"
                                            class="px-4 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-second-50 text-gray-700 font-semibold transition-all duration-300 shadow-md hover:shadow-lg hover:scale-105 flex items-center justify-center min-w-[3rem]">

                                            <span wire:loading wire:target="goToPage({{ $totalPages }})"
                                                class="flex items-center">
                                                <div class="relative w-5 h-5">
                                                    <div class="w-5 h-5 rounded-full border border-gray-200"></div>
                                                    <div
                                                        class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                                    </div>
                                                    <div class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                        style="animation-direction: reverse; animation-duration: 1s;">
                                                    </div>
                                                </div>
                                            </span>

                                            <span wire:loading.remove
                                                wire:target="goToPage({{ $totalPages }})">{{ $totalPages }}</span>
                                        </button>
                                    @endif
                                </div>

                                {{-- Current Page (for mobile) --}}
                                <div
                                    class="md:hidden px-5 py-2.5 rounded-xl bg-gradient-to-r from-second-500 to-zinc-500 text-white font-bold shadow-lg ring-2 ring-second-300">
                                    {{ $currentPage }}
                                </div>

                                {{-- Next Button --}}
                                <button wire:click="nextPage" wire:loading.attr="disabled" wire:target="nextPage"
                                    @if (!$this->hasNextPage()) disabled @endif
                                    class="group relative px-5 py-2.5 rounded-xl border-2 border-second-500/40 bg-white hover:bg-gradient-to-r hover:from-second-500 hover:to-second-600 text-gray-700 hover:text-white font-semibold transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-700 flex items-center gap-2 shadow-md hover:shadow-xl hover:scale-105 disabled:hover:scale-100">

                                    <span wire:loading.remove wire:target="nextPage"
                                        class="hidden sm:inline">{{ __('Next') }}</span>

                                    <span wire:loading wire:target="nextPage" class="flex items-center">
                                        <div class="relative w-5 h-5">
                                            <div class="w-5 h-5 rounded-full border border-gray-200"></div>
                                            <div
                                                class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-t-second-500 border-r-second-500 animate-spin">
                                            </div>
                                            <div class="absolute top-0 left-0 w-5 h-5 rounded-full border border-transparent border-b-zinc-500 border-l-zinc-500 animate-spin"
                                                style="animation-direction: reverse; animation-duration: 1s;"></div>
                                        </div>
                                    </span>

                                    <svg wire:loading.remove wire:target="nextPage"
                                        class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
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
