<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50">
    <style>
    [x-cloak] { display: none !important; }
</style>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Featured TikTok Creators</h1>
            <p class="text-gray-600">Latest videos from your featured content creators</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
            @foreach($featuredUsers as $user)
                @php
                    $profile = $profiles[$user['username']] ?? null;
                    $userInfo = $profile['user'] ?? null;
                    $avatar = $userInfo['avatarLarger'] ?? $userInfo['avatarMedium'] ?? $userInfo['avatarThumb'] ?? null;
                    $followerCount = $profile['stats']['followerCount'] ?? 0;
                    $nickname = $userInfo['nickname'] ?? $user['display_name'];
                @endphp

                <button wire:click="filterByUser('{{ $user['username'] }}')" class="group relative bg-white rounded-xl p-4 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 @if($selectedUser === $user['username']) ring-4 ring-{{ $user['color'] }}-500 @endif">
                    <div class="flex justify-center mb-3">
                        @if($avatar)
                            <img src="{{ $avatar }}" alt="{{ $nickname }}" class="w-16 h-16 rounded-full border-3 border-{{ $user['color'] }}-500 object-cover" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($nickname) }}&size=200&background=667eea&color=fff';">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-{{ $user['color'] }}-400 to-{{ $user['color'] }}-600 flex items-center justify-center">
                                <span class="text-white text-xl font-bold">{{ strtoupper(substr($user['username'], 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>

                    <h3 class="font-semibold text-gray-900 text-sm mb-1 truncate">{{ $nickname }}</h3>
                    <p class="text-xs text-gray-500 truncate">{{ '@' . $user['username'] }}</p>

                    @if($followerCount > 0)
                        <p class="text-xs text-gray-600 mt-2">
                            <span class="font-semibold">{{ $this->formatNumber($followerCount) }}</span> Followers
                        </p>
                    @endif
                </button>
            @endforeach

            <button wire:click="filterByUser('all')" class="group relative bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-xl p-4 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 @if($selectedUser === 'all') ring-4 ring-purple-600 @endif">
                <div class="flex justify-center mb-3">
                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-semibold text-sm mb-1">All Creators</h3>
                <p class="text-xs opacity-90">{{ count($videos) }} videos</p>
            </button>
        </div>

        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-600">
                @if($selectedUser === 'all')
                    Showing <span class="font-semibold text-gray-900">{{ count($filteredVideos) }}</span> videos from all creators
                @else
                    Showing <span class="font-semibold text-gray-900">{{ count($filteredVideos) }}</span> videos from <span class="font-semibold">{{ '@' . $selectedUser }}</span>
                @endif
            </div>

            <button wire:click="refresh" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:shadow-md transition-all duration-200" wire:loading.attr="disabled">
                <svg wire:loading.remove wire:target="refresh" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <svg wire:loading wire:target="refresh" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="refresh">Refresh</span>
                <span wire:loading wire:target="refresh">Refreshing...</span>
            </button>
        </div>

        @if($error)
            <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-700 font-medium">{{ $error }}</p>
                </div>
            </div>
        @endif

        @if($loading)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @for($i = 0; $i < 12; $i++)
                    <div class="animate-pulse bg-white rounded-xl overflow-hidden shadow-md">
                        <div class="bg-gray-300 aspect-[9/16]"></div>
                        <div class="p-4">
                            <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                            <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                        </div>
                    </div>
                @endfor
            </div>
        @endif

        @if(!$loading && count($filteredVideos) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($filteredVideos as $index => $video)
                    @php
                        $videoId = $video['aweme_id'] ?? $video['video_id'] ?? '';
                        $title = $video['title'] ?? 'TikTok Video';
                        $createTime = $video['create_time'] ?? time();
                        $cover = $video['cover'] ?? $video['origin_cover'] ?? $video['ai_dynamic_cover'] ?? '';
                        $playUrl = $video['play'] ?? '';
                        $duration = $video['duration'] ?? 0;
                        $playCount = $video['play_count'] ?? 0;
                        $diggCount = $video['digg_count'] ?? 0;
                        $commentCount = $video['comment_count'] ?? 0;
                        $author = $video['author'] ?? [];
                        $username = $video['_username'] ?? $author['unique_id'] ?? 'unknown';
                        $authorName = $author['nickname'] ?? $username;
                        $authorAvatar = $author['avatar'] ?? '';
                        $musicInfo = $video['music_info'] ?? [];
                        $musicTitle = $musicInfo['title'] ?? 'Original Sound';
                    @endphp

                    <div x-data="{ playing: false, playVideo() { this.playing = true; this.$nextTick(() => { const video = this.$refs.video; if (video) { document.querySelectorAll('video').forEach(v => { if (v !== video && !v.paused) { v.pause(); } }); video.play().catch(err => { console.error('Play error:', err); alert('Unable to play video.'); this.playing = false; }); } }); }, stopVideo() { this.playing = false; if (this.$refs.video) { this.$refs.video.pause(); this.$refs.video.currentTime = 0; } } }" class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                        <div class="relative aspect-[9/16] bg-gradient-to-br from-pink-100 to-purple-100 overflow-hidden">
                            @if($playUrl)
                                <video x-ref="video" x-show="playing" x-on:ended="stopVideo()" x-on:error="playing = false; alert('Video error');" class="w-full h-full object-cover" poster="{{ $cover }}" controls playsinline preload="metadata" controlsList="nodownload" style="display: none;" x-cloak>
                                    <source src="{{ $playUrl }}" type="video/mp4">
                                </video>

                                <div x-show="!playing" x-on:click="playVideo()" class="absolute inset-0 cursor-pointer">
                                    <img src="{{ $cover }}" alt="{{ $title }}" class="w-full h-full object-cover" loading="lazy">

                                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center transition-all duration-300 hover:bg-opacity-50">
                                        <div class="transform hover:scale-110 transition-transform duration-300">
                                            <div class="w-20 h-20 rounded-full bg-white bg-opacity-90 flex items-center justify-center shadow-2xl">
                                                <svg class="w-10 h-10 text-pink-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <img src="{{ $cover }}" alt="{{ $title }}" class="w-full h-full object-cover" loading="lazy">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <p class="text-white text-sm">Video unavailable</p>
                                </div>
                            @endif

                            @if($duration > 0)
                                <div class="absolute top-3 right-3 bg-black bg-opacity-75 text-white text-xs font-bold px-2.5 py-1 rounded-md backdrop-blur-sm z-20">
                                    {{ gmdate('i:s', $duration) }}
                                </div>
                            @endif

                            <div class="absolute top-3 left-3 flex items-center space-x-2 bg-white bg-opacity-90 backdrop-blur-sm rounded-full px-3 py-1.5 shadow-lg z-20">
                                @if($authorAvatar)
                                    <img src="{{ $authorAvatar }}" alt="{{ $authorName }}" class="w-5 h-5 rounded-full">
                                @endif
                                <span class="text-xs font-semibold text-gray-900">{{ '@' . $username }}</span>
                            </div>

                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black via-black/70 to-transparent z-20">
                                <div class="grid grid-cols-3 gap-2 text-white text-xs font-semibold">
                                    @if($playCount > 0)
                                        <div class="flex items-center justify-center backdrop-blur-sm bg-white/20 rounded-full px-2 py-1">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $this->formatNumber($playCount) }}
                                        </div>
                                    @endif

                                    @if($diggCount > 0)
                                        <div class="flex items-center justify-center backdrop-blur-sm bg-white/20 rounded-full px-2 py-1">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $this->formatNumber($diggCount) }}
                                        </div>
                                    @endif

                                    @if($commentCount > 0)
                                        <div class="flex items-center justify-center backdrop-blur-sm bg-white/20 rounded-full px-2 py-1">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $this->formatNumber($commentCount) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-4">
                            <p class="text-gray-900 text-sm font-medium mb-2 line-clamp-2 min-h-[2.5rem]">
                                {{ $title }}
                            </p>

                            @if($musicTitle)
                                <div class="flex items-center text-xs text-gray-500 mb-3">
                                    <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                    <span class="truncate">{{ $musicTitle }}</span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                @if($createTime)
                                    <span class="flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ \Carbon\Carbon::createFromTimestamp($createTime)->diffForHumans() }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                @if($playUrl)
                                    <button x-on:click="playVideo()" class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-pink-500 to-purple-600 text-white text-sm font-bold rounded-lg hover:from-pink-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-xl">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                            Play Video
                                        </span>
                                    </button>
                                @endif

                                <a href="https://www.tiktok.com/@{{ $username }}/video/{{ $videoId }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-bold rounded-lg transition-all duration-200 flex items-center justify-center" title="View on TikTok">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(!$loading && count($filteredVideos) == 0)
            <div class="bg-white rounded-xl shadow-md border-2 border-dashed border-gray-300 p-16 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">No videos found</h3>
                <p class="text-gray-600 mb-4">No videos available for the selected user</p>
            </div>
        @endif
    </div>
</div>

