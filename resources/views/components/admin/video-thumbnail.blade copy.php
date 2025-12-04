@props(['video'])

<div class="flex items-center gap-3">
    {{-- Thumbnail Container --}}
    <div class="relative w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 shadow-sm group cursor-pointer"
         onclick="openVideoModal{{ $video->id }}()">
        @if($video->thumbnail_url)
            <img
                src="{{ $video->thumbnail_url }}"
                alt="{{ $video->title ?: 'Video thumbnail' }}"
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                loading="lazy"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            />
            {{-- Fallback icon if image fails --}}
            <div class="hidden w-full h-full items-center justify-center bg-gray-100 dark:bg-gray-800">
                <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        {{-- Play icon overlay --}}
        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="w-8 h-8 rounded-full bg-white/90 dark:bg-gray-900/90 flex items-center justify-center shadow-lg">
                <svg class="w-4 h-4 text-gray-900 dark:text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                </svg>
            </div>
        </div>

        {{-- Duration badge --}}
        @if($video->duration)
            <div class="absolute bottom-1 right-1 px-1.5 py-0.5 bg-black/75 rounded text-white text-[10px] font-medium">
                {{ gmdate('i:s', $video->duration) }}
            </div>
        @endif
    </div>

    {{-- Video Info --}}
    <div class="flex-1 min-w-0">
        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
            {{ $video->author_nickname ?: $video->username ?: 'Unknown User' }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-0.5">
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
                {{ $video->formatted_play_count ?? '0' }}
            </span>
            <span>•</span>
            <span class="flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                {{ $video->formatted_digg_count ?? '0' }}
            </span>
        </div>
    </div>
</div>

{{-- Video Modal Popup --}}
<div id="videoModal{{ $video->id }}" class="fixed inset-0 z-50 hidden items-start justify-center bg-black/90 backdrop-blur-sm p-4 overflow-y-auto pt-16">
    <div class="relative w-full max-w-5xl mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-2xl overflow-hidden my-4">
        {{-- Close Button --}}
        <button
            onclick="closeVideoModal{{ $video->id }}()"
            class="absolute -top-12 right-0 z-10 w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Video Player --}}
        <div class="relative w-full bg-black" style="aspect-ratio: 16/9;">
            @if($video->play_url ?? $video->video_url ?? $video->download_url ?? null)
                <video
                    id="videoPlayer{{ $video->id }}"
                    class="w-full h-full object-contain"
                    controls
                    playsinline
                    webkit-playsinline
                    x5-playsinline
                    poster="{{ $video->thumbnail_url }}"
                    preload="metadata"
                    controlslist="nodownload"
                    disablePictureInPicture>
                    <source src="{{ $video->play_url ?? $video->video_url ?? $video->download_url }}" type="video/mp4">
                    <source src="{{ $video->play_url ?? $video->video_url ?? $video->download_url }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>
                {{-- Loading Spinner --}}
                <div id="videoLoader{{ $video->id }}" class="absolute inset-0 flex items-center justify-center bg-black/50 hidden">
                    <div class="animate-spin rounded-full h-12 w-12 border-4 border-white border-t-transparent"></div>
                </div>
            @else
                <div class="flex items-center justify-center h-full text-white">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-lg">Video URL not available</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Video Details --}}
        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                {{ $video->title ?: 'Untitled Video' }}
            </h3>
            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                    {{ $video->author_nickname ?: $video->username ?: 'Unknown User' }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ $video->formatted_play_count ?? '0' }} views
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    {{ $video->formatted_digg_count ?? '0' }} likes
                </span>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Modal Control --}}
<script>
    (function() {
        const modalId = 'videoModal{{ $video->id }}';
        const videoId = 'videoPlayer{{ $video->id }}';
        const loaderId = 'videoLoader{{ $video->id }}';
        let isModalOpen = false;

        window['openVideoModal{{ $video->id }}'] = function() {
            const modal = document.getElementById(modalId);
            const video = document.getElementById(videoId);
            const loader = document.getElementById(loaderId);

            if (!modal || !video || isModalOpen) return;

            isModalOpen = true;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Optimize video playback
            if (video) {
                // Show loader initially
                if (loader) loader.classList.remove('hidden');

                // Set optimal playback settings
                video.preload = 'auto';
                video.playsInline = true;

                // Request animation frame for smoother load
                requestAnimationFrame(() => {
                    video.load();

                    // Try to play after buffer
                    const tryPlay = () => {
                        if (video.readyState >= 2) { // HAVE_CURRENT_DATA
                            if (loader) loader.classList.add('hidden');
                            video.play().catch(err => {
                                console.log('Autoplay prevented, user action required');
                            });
                        } else {
                            video.addEventListener('canplay', () => {
                                if (loader) loader.classList.add('hidden');
                                video.play().catch(() => {});
                            }, { once: true });
                        }
                    };

                    setTimeout(tryPlay, 100);
                });

                // Prevent freezing with buffering handler
                video.addEventListener('waiting', function() {
                    if (loader) loader.classList.remove('hidden');
                });

                video.addEventListener('playing', function() {
                    if (loader) loader.classList.add('hidden');
                });

                video.addEventListener('canplaythrough', function() {
                    if (loader) loader.classList.add('hidden');
                });

                // Handle errors
                video.addEventListener('error', function(e) {
                    if (loader) loader.classList.add('hidden');
                    console.error('Video error:', e);
                    alert('Video playback error. Please try again.');
                }, { once: true });
            }
        };

        window['closeVideoModal{{ $video->id }}'] = function() {
            const modal = document.getElementById(modalId);
            const video = document.getElementById(videoId);

            if (!modal || !isModalOpen) return;

            isModalOpen = false;

            if (video) {
                video.pause();
                video.currentTime = 0;
                // Clear buffer
                video.removeAttribute('src');
                video.load();
                video.src = "{{ $video->play_url ?? $video->video_url ?? $video->download_url }}";
            }

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        };

        // Close by clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this && isModalOpen) {
                        window['closeVideoModal{{ $video->id }}']();
                    }
                });
            }
        });

        // Close with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isModalOpen) {
                window['closeVideoModal{{ $video->id }}']();
            }
        });
    })();
</script>
