<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- API Subscription Warning -->
        @if(!config('tiktok.rapidapi_key'))
            <div class="mb-6 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-lg p-6 shadow-lg">
                <div class="flex items-start">
                    <svg class="w-8 h-8 text-yellow-600 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-yellow-800 mb-2">
                            ⚠️ API Subscription প্রয়োজন
                        </h3>
                        <p class="text-yellow-700 mb-3">
                            এখন <strong>Demo Data</strong> দেখাচ্ছে। আসল TikTok ভিডিও দেখার জন্য:
                        </p>
                        <ol class="list-decimal list-inside space-y-2 text-yellow-800 mb-4">
                            <li>
                                <a href="https://rapidapi.com/DataFanatic/api/tiktok-scraper7" 
                                   target="_blank" 
                                   class="underline hover:text-yellow-900 font-semibold">
                                    RapidAPI TikTok Scraper
                                </a> তে যান
                            </li>
                            <li><strong>"Subscribe to Test"</strong> বাটনে ক্লিক করুন</li>
                            <li><strong>Free/Basic Plan</strong> সিলেক্ট করুন</li>
                            <li>API Key copy করে <code class="bg-yellow-100 px-2 py-1 rounded text-sm">.env</code> ফাইলে যোগ করুন</li>
                        </ol>
                        <div class="flex gap-3">
                            <a href="https://rapidapi.com/DataFanatic/api/tiktok-scraper7" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-colors shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Subscribe করুন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                Featured TikTok Creators
                @if(!config('tiktok.rapidapi_key'))
                    <span class="text-sm font-normal text-yellow-600">(Demo Mode)</span>
                @endif
            </h1>
            <p class="text-gray-600">
                Latest videos from top content creators
            </p>
        </div>

        <!-- Featured Users Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
            @foreach($featuredUsers as $user)
                @php
                    $profile = $profiles[$user['username']] ?? null;
                    $avatar = $profile['user']['avatar_larger'] ?? $profile['user']['avatar'] ?? null;
                    $followerCount = $profile['user']['follower_count'] ?? 0;
                @endphp
                
                <button
                    wire:click="filterByUser('{{ $user['username'] }}')"
                    class="group relative bg-white rounded-xl p-4 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 {{ $selectedUser === $user['username'] ? 'ring-4 ring-' . $user['color'] . '-500' : '' }}"
                >
                    <div class="flex justify-center mb-3">
                        @if($avatar)
                            <img 
                                src="{{ $avatar }}" 
                                alt="{{ $user['display_name'] }}"
                                class="w-16 h-16 rounded-full border-3 border-{{ $user['color'] }}-500 object-cover"
                            >
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-{{ $user['color'] }}-400 to-{{ $user['color'] }}-600 flex items-center justify-center">
                                <span class="text-white text-xl font-bold">{{ strtoupper(substr($user['username'], 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="font-semibold text-gray-900 text-sm mb-1 truncate">
                        {{ $user['display_name'] }}
                    </h3>
                    <p class="text-xs text-gray-500 truncate">@{{ $user['username'] }}</p>
                    
                    @if($followerCount > 0)
                        <p class="text-xs text-gray-600 mt-2">
                            {{ $this->formatNumber($followerCount) }} Followers
                        </p>
                    @endif
                </button>
            @endforeach

            <button
                wire:click="filterByUser('all')"
                class="group relative bg-gradient-to-br from-purple-500 to-pink-500 text-white rounded-xl p-4 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 {{ $selectedUser === 'all' ? 'ring-4 ring-purple-600' : '' }}"
            >
                <div class="flex justify-center mb-3">
                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-semibold text-sm mb-1">All Creators</h3>
                <p class="text-xs opacity-90">All videos</p>
            </button>
        </div>

        <!-- Refresh Button -->
        <div class="flex justify-end mb-6">
            <button 
                wire:click="refresh" 
                class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:shadow-md transition-all duration-200"
                wire:loading.attr="disabled"
            >
                <svg wire:loading.remove wire:target="refresh" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <svg wire:loading wire:target="refresh" class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="refresh">Refresh</span>
                <span wire:loading wire:target="refresh">Loading...</span>
            </button>
        </div>

        <!-- Error Message -->
        @if($error)
            <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-700">{{ $error }}</p>
                </div>
            </div>
        @endif

        <!-- Loading Skeleton -->
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
        @else
            @php
                $displayVideos = $filteredVideos;
            @endphp

            @if(count($displayVideos) > 0)
                <div>
                    <div class="mb-4 text-sm text-gray-600">
                        Showing: 
                        <span class="font-semibold text-gray-900">
                            @if($selectedUser === 'all')
                                All creators' {{ count($displayVideos) }} videos
                            @else
                                {{ $selectedUser }}'s {{ count($displayVideos) }} videos
                            @endif
                        </span>
                    </div>

                    <!-- Videos Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($displayVideos as $index => $video)
                            @php
                                $videoId = $video['aweme_id'] ?? $video['video']['id'] ?? $video['id'] ?? '';
                                $desc = $video['desc'] ?? $video['description'] ?? 'No description';
                                $createTime = $video['create_time'] ?? $video['createTime'] ?? time();
                                $cover = $video['video']['cover'] ?? $video['video']['dynamic_cover'] ?? $video['cover'] ?? '';
                                $playAddr = $video['video']['play_addr']['url_list'][0] ?? $video['video']['play_addr'] ?? $video['video']['play_url'] ?? '';
                                $duration = $video['video']['duration'] ?? $video['duration'] ?? 0;
                                
                                $stats = $video['statistics'] ?? $video['stats'] ?? [];
                                $playCount = $stats['play_count'] ?? $stats['playCount'] ?? 0;
                                $diggCount = $stats['digg_count'] ?? $stats['diggCount'] ?? 0;
                                $commentCount = $stats['comment_count'] ?? $stats['commentCount'] ?? 0;
                                
                                $username = $video['_username'] ?? 'unknown';
                            @endphp
                            
                            <div class="group bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                                <div class="relative aspect-[9/16] bg-gradient-to-br from-pink-100 to-purple-100 overflow-hidden">
                                    <!-- Video Player with Poster -->
                                    <div class="video-container-{{ $index }} relative w-full h-full">
                                        @if($playAddr)
                                            <!-- Video Element (Hidden by default) -->
                                            <video 
                                                id="video-{{ $index }}"
                                                class="w-full h-full object-cover hidden"
                                                poster="{{ $cover }}"
                                                controls
                                                playsinline
                                                preload="metadata"
                                            >
                                                <source src="{{ $playAddr }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            
                                            <!-- Cover Image (Shown by default) -->
                                            <img 
                                                id="cover-{{ $index }}"
                                                src="{{ $cover }}" 
                                                alt="{{ $desc }}"
                                                class="w-full h-full object-cover cursor-pointer"
                                                loading="lazy"
                                            >
                                        @else
                                            <!-- Fallback to cover image only -->
                                            <img 
                                                src="{{ $cover }}" 
                                                alt="{{ $desc }}"
                                                class="w-full h-full object-cover"
                                                loading="lazy"
                                            >
                                        @endif
                                        
                                        <!-- Play Button Overlay -->
                                        @if($playAddr)
                                            <div id="play-overlay-{{ $index }}" class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center cursor-pointer transition-all duration-300 hover:bg-opacity-50">
                                                <div class="transform hover:scale-110 transition-transform duration-300">
                                                    <svg class="w-20 h-20 text-white drop-shadow-2xl" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @if($duration > 0)
                                        <div class="absolute top-3 right-3 bg-black bg-opacity-75 text-white text-xs font-bold px-2.5 py-1 rounded-md backdrop-blur-sm z-10">
                                            {{ gmdate('i:s', $duration) }}
                                        </div>
                                    @endif

                                    <div class="absolute top-3 left-3 bg-white bg-opacity-90 backdrop-blur-sm text-gray-900 text-xs font-semibold px-3 py-1 rounded-full shadow-lg z-10">
                                        @{{ $username }}
                                    </div>

                                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black via-black/70 to-transparent z-10">
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
                                    <p class="text-gray-900 text-sm font-medium mb-3 line-clamp-2 min-h-[2.5rem]">
                                        {{ $desc }}
                                    </p>
                                    
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

                                    <a 
                                        href="https://www.tiktok.com/@{{ $username }}/video/{{ $videoId }}" 
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="block w-full text-center px-4 py-2.5 bg-gradient-to-r from-pink-500 to-purple-600 text-white text-sm font-bold rounded-lg hover:from-pink-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-xl"
                                    >
                                        <span class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                            </svg>
                                            View on TikTok
                                        </span>
                                    </a>
                                </div>
                            </div>

                            @if($playAddr)
                                <script>
                                    (function() {
                                        const video = document.getElementById('video-{{ $index }}');
                                        const cover = document.getElementById('cover-{{ $index }}');
                                        const overlay = document.getElementById('play-overlay-{{ $index }}');
                                        
                                        if (video && cover && overlay) {
                                            // Play video when clicking overlay or cover
                                            const playVideo = function(e) {
                                                e.preventDefault();
                                                e.stopPropagation();
                                                
                                                // Hide cover and overlay
                                                cover.classList.add('hidden');
                                                overlay.classList.add('hidden');
                                                
                                                // Show and play video
                                                video.classList.remove('hidden');
                                                video.play().catch(err => {
                                                    console.error('Error playing video:', err);
                                                    // If play fails, show cover again
                                                    video.classList.add('hidden');
                                                    cover.classList.remove('hidden');
                                                    overlay.classList.remove('hidden');
                                                });
                                            };
                                            
                                            overlay.addEventListener('click', playVideo);
                                            cover.addEventListener('click', playVideo);
                                            
                                            // Show cover again when video ends
                                            video.addEventListener('ended', function() {
                                                video.classList.add('hidden');
                                                cover.classList.remove('hidden');
                                                overlay.classList.remove('hidden');
                                            });
                                        }
                                    })();
                                </script>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md border-2 border-dashed border-gray-300 p-16 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">No videos found</h3>
                    <p class="text-gray-600">Subscribe to TikTok API to see real videos</p>
                </div>
            @endif
        @endif
    </div>
</div>