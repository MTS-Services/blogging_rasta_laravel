<div>

    @section('meta')
        <meta property="og:title" content="{{ $data->title }}">
        <meta property="og:description" content="{{ $data->video_description ?? $data->title }}">
        <meta property="og:image" content="{{ $data->cover }}">
        <meta property="og:url" content="{{ url()->current() }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $data->title }}">
        <meta name="twitter:description" content="{{ $data->video_description ?? $data->title }}">
        <meta name="twitter:image" content="{{ $data->cover }}">
    @endsection
    {{-- Hero Section with Video --}}
    <section class="bg-gradient">
        <div class="container pt-20 pb-12 lg:pt-24">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                {{-- Video Player Section - Same as Home Page --}}
                <div class="w-full lg:w-3/5">
                    <div x-data="{
                        playing: false,
                        playVideo() {
                            this.playing = true;
                            this.$nextTick(() => {
                                const video = this.$refs.mainVideo;
                                if (video) {
                                    video.play().catch(err => {
                                        console.error('Play error:', err);
                                        this.playing = false;
                                    });
                                }
                            });
                        },
                        stopVideo() {
                            this.playing = false;
                            if (this.$refs.mainVideo) {
                                this.$refs.mainVideo.pause();
                                this.$refs.mainVideo.currentTime = 0;
                            }
                        }
                    }"
                        class="relative w-full aspect-[1/1] max-w-[500px] mx-auto lg:max-w-none overflow-hidden rounded-2xl shadow-2xl">
                        @if ($data->play_url)
                            {{-- Video Element --}}
                            <video x-ref="mainVideo" x-show="playing" x-on:ended="stopVideo()"
                                x-on:error="playing = false" class="w-full h-full object-cover"
                                poster="{{ $data->cover }}" playsinline preload="metadata" controls
                                controlsList="nodownload" x-cloak>
                                <source src="{{ $data->play_url }}" type="video/mp4">
                            </video>

                            {{-- Thumbnail --}}
                            <div x-show="!playing" x-on:click="playVideo()" class="absolute inset-0 cursor-pointer">
                                @if ($data->cover)
                                    <img src="{{ $data->cover }}" alt="{{ $data->title }}"
                                        class="w-full h-full object-cover" loading="lazy">
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
                </div>

                {{-- Video Info Section --}}
                <div class="w-full lg:w-2/5 flex flex-col">
                    {{-- Author Info --}}
                    <div class="flex items-center gap-4 mb-6 p-4 bg-white rounded-xl shadow-sm">
                        <img src="{{ $data->author_avatar }}" alt="{{ $data->author_nickname }}"
                            class="w-16 h-16 rounded-full object-cover border-4 border-second-500"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($data->author_nickname) }}&size=200&background=667eea&color=fff'">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold font-montserrat text-text-primary">
                                {{ $data->author_nickname }}
                            </h3>
                            <p class="text-sm text-text-muted font-inter">
                                {{ $data->username }}
                            </p>
                        </div>
                    </div>

                    {{-- Video Title --}}
                    <h1 class="text-3xl md:text-4xl font-bold font-montserrat text-text-primary mb-4">
                        {{ $data->title }}
                    </h1>

                    {{-- Video Description --}}
                    @if ($data->video_description)
                        <p class="text-base md:text-lg text-text-primary font-inter mb-6 leading-relaxed">
                            {{ $data->video_description }}
                        </p>
                    @endif

                    {{-- Video Stats --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <svg class="w-5 h-5 text-second-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-2xl font-bold font-playfair text-second-800">
                                    {{ $this->formatNumber($data->play_count) }}
                                </h4>
                            </div>
                            <p class="text-sm text-text-muted font-inter">{{ __('Views') }}</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-2xl font-bold font-playfair text-zinc-500">
                                    {{ $this->formatNumber($data->digg_count) }}
                                </h4>
                            </div>
                            <p class="text-sm text-text-muted font-inter">{{ __('Likes') }}</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h4 class="text-2xl font-bold font-playfair text-second-800">
                                    {{ $this->formatNumber($data->comment_count) }}
                                </h4>
                            </div>
                            <p class="text-sm text-text-muted font-inter">{{ __('Comments') }}</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                </svg>
                                <h4 class="text-2xl font-bold font-playfair text-zinc-500">
                                    {{ $this->formatNumber($data->share_count) }}
                                </h4>
                            </div>
                            <p class="text-sm text-text-muted font-inter">{{ __('Shares') }}</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Share Button --}}
                        <button onclick="openShareModal()"
                            class="flex-1 py-4 px-6 bg-gradient-to-r from-second-500 to-zinc-500 text-white font-semibold font-inter rounded-xl hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                            {{ __('Share Video') }}
                        </button>

                        {{-- Watch on TikTok Button --}}
                        {{-- <a href="https://www.tiktok.com/@{{ $data - > username }}/video/{{ $data->video_id }}"
                            target="_blank"
                            class="flex-1 py-4 px-6 bg-white border-2 border-second-500 text-text-primary font-semibold font-inter rounded-xl hover:bg-second-50 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                            </svg>
                            {{ __('Watch on TikTok') }}
                        </a> --}}
                    </div>

                    {{-- Music Info --}}
                    @if ($data->music_title)
                        <div class="mt-6 p-4 bg-second-100 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-second-500 to-zinc-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-text-primary font-inter truncate">
                                        {{ $data->music_title }}
                                    </p>
                                    @if ($data->music_author)
                                        <p class="text-xs text-text-muted font-inter truncate">
                                            {{ $data->music_author }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Share Modal --}}
    <div id="shareModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl transform transition-all">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold font-montserrat text-text-primary">
                    {{ __('Share Video') }}
                </h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Video Preview --}}
            <div class="mb-6 p-4 bg-second-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <img src="{{ $data->cover }}" alt="{{ $data->title }}"
                        class="w-20 h-20 rounded-lg object-cover">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-text-primary font-inter truncate">
                            {{ $data->title }}
                        </p>
                        <p class="text-sm text-text-muted font-inter">
                            {{ $data->author_nickname }}
                        </p>
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
                    <button onclick="shareVia('whatsapp')"
                        class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <span class="font-semibold text-green-600">WhatsApp</span>
                    </button>

                    {{-- Facebook --}}
                    <button onclick="shareVia('facebook')"
                        class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="font-semibold text-blue-600">Facebook</span>
                    </button>

                    {{-- Twitter --}}
                    <button onclick="shareVia('twitter')"
                        class="flex items-center gap-3 p-3 bg-sky-50 hover:bg-sky-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-sky-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                        <span class="font-semibold text-sky-600">Twitter</span>
                    </button>
                    <button onclick="shareVia('messenger')"
                        class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0C5.373 0 0 4.974 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.627 0 12-4.974 12-11.111C24 4.974 18.627 0 12 0zm1.191 14.963l-3.055-3.26-5.963 3.26L10.732 8l3.131 3.259L19.752 8l-6.561 6.963z" />
                        </svg>
                        <span class="font-semibold text-blue-500">Messenger</span>
                    </button>

                    {{-- Email --}}
                    <button onclick="shareVia('email')"
                        class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <span class="font-semibold text-gray-600">Email</span>
                    </button>
                </div>
            </div>

            {{-- Copy Link Section --}}
            <div class="space-y-3">
                <p class="text-sm font-semibold text-text-primary font-inter">
                    {{ __('Or copy link:') }}
                </p>
                <div class="flex gap-2">
                    <input type="text" id="shareLink" value="{{ url()->current() }}" readonly
                        class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl font-inter text-sm text-text-primary focus:outline-none focus:border-second-500">
                    <button onclick="copyLink()"
                        class="px-6 py-3 bg-gradient-to-r from-second-500 to-zinc-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Copy') }}</span>
                    </button>
                </div>
            </div>

            {{-- Success Message --}}
            <div id="copySuccess"
                class="hidden mt-3 p-3 bg-green-50 text-green-700 rounded-xl text-sm font-inter text-center">
                ✓ {{ __('Link copied to clipboard!') }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Video player controls
            document.addEventListener('DOMContentLoaded', function() {
                const video = document.getElementById('mainVideo');
                const playButton = document.getElementById('customPlayButton');

                if (video && playButton) {
                    video.addEventListener('play', function() {
                        playButton.style.display = 'none';
                    });

                    video.addEventListener('pause', function() {
                        if (video.currentTime > 0 && !video.ended) {
                            playButton.style.display = 'flex';
                        }
                    });

                    video.addEventListener('ended', function() {
                        playButton.style.display = 'flex';
                    });
                }
            });

            // Share modal functions
            function openShareModal() {
                document.getElementById('shareModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeShareModal() {
                document.getElementById('shareModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
                document.getElementById('copySuccess').classList.add('hidden');
            }

            // Close modal on outside click
            document.getElementById('shareModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeShareModal();
                }
            });

            // Share via different platforms
            function shareVia(platform) {
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent('{{ $data->title }}');
                const description = encodeURIComponent('{{ $data->video_description ?? $data->title }}');

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
                        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                            .userAgent);
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
            }

            // Copy link function
            function copyLink() {
                const linkInput = document.getElementById('shareLink');
                linkInput.select();
                document.execCommand('copy');

                const successMsg = document.getElementById('copySuccess');
                successMsg.classList.remove('hidden');

                setTimeout(() => {
                    successMsg.classList.add('hidden');
                }, 3000);
            }

            // ESC key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeShareModal();
                }
            });
        </script>
    @endpush
</div>
