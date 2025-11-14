<div class="min-h-screen bg-bg-primary py-8 sm:py-12 px-4">
    <div class="container mx-auto">
        <div class="">
            {{-- Header --}}
            <div class="mb-3 sm:mb-5 lg:mb-8 mx-auto max-w-xl">
                <h1 class="text-2xl sm:text-3xl md:text-4xl xl:text-5xl font-bold text-text-primary mb-1.5 sm:mb-3 ">{{ __('Video Feed') }}
                </h1>
                <p class="text-text-secondary text-base ">{{ __('Trending skincare routines and beauty tips from TikTok') }}</p>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex flex-wrap gap-1 sm:gap-2 xl:ps-20 mb-5 xl:mb-10 max-w-2xl mx-auto">
                @foreach ($categories as $category)
                    <button wire:click="setCategory('{{ $category }}')"
                        class="px-1.5 sm:px-3 py-2 rounded-lg font-inter text-xs sm:text-sm font-medium transition-colors
                    {{ $activeCategory === $category
                        ? 'bg-second-500 text-white'
                        : 'bg-second-800/10 text-second-500 hover:bg-second-400/40' }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>

            {{-- Video Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($filteredVideos as $video)
                    <div
                        class="bg-bg-primary p-4 rounded-2xl shadow-md border border-second-500/40 overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="relative w-full sm:h-80 lg:h-98 h-70 mb-2">
                            <img src="{{ $video['image'] }}" class="w-full h-full object-cover">
                        </div>

                        <div>
                            <p class="font-bold text-text-primary mb-1">{{ $video['title'] }}</p>
                            <p class="text-xs text-text-secondary mb-4">{{ $video['author'] }}</p>
                            <div class="flex items-center justify-evenly w-full gap-4 py-2 border-t border-b ">
                                {{-- Likes --}}
                                <button
                                    class="flex items-center gap-1 text-scond-800/20 transition-colors">
                                    <flux:icon name="heart" class="w-5 h-5 stroke-text-muted" />
                                    <span class="text-base text-text-muted">{{ $video['likes'] }}</span>
                                </button>

                                {{-- Comments --}}
                                <button
                                    class="flex items-center gap-1 text-scond-800/20  transition-colors">
                                    <flux:icon name="chat-bubble-oval-left" class="w-5 h-5" />
                                    <span class="text-base text-text-muted">{{ $video['comments'] }}</span>
                                </button>

                                {{-- Share --}}
                                <button
                                    class="flex items-center gap-1 text-scond-800/20 0 transition-colors">
                                    <flux:icon name="share" class="w-5 h-5" />
                                    <span class="text-base text-text-muted">Share</span>
                                </button>
                            </div>


                            {{-- Tags --}}
                            <div class="flex flex-wrap  gap-2 sm:gap-3 mt-1">
                                @foreach ($video['tags'] as $tag)
                                    <span class="text-xs sm:text-sm text-second-500 font-medium">{{ $tag }}</span>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
