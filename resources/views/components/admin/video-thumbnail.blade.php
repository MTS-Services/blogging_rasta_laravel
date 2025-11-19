

@props(['video'])

<div class="flex items-center gap-3">
    {{-- Thumbnail Container --}}
    <div class="relative w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 shadow-sm group">
        @if($video->cover)
            <img 
                src="{{ $video->cover }}" 
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
            <div class="w-full h-full flex items-center justify-center">
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