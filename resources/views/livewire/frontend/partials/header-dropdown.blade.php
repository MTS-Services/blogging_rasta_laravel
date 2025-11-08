<section 
    class="absolute container top-full left-0 right-0 z-50 mt-0"
    x-data 
    x-show="open != ''"
    x-transition
    x-cloak
    x-effect="$wire.setGameCategorySlug(open)"
     @mouseleave="open = ''"

    
>
    <div class="  relative" x-on:click.outside="open = ''">
        {{-- 🔄 Modern Loader --}}
        {{-- <div 
            wire:loading.flex 
            wire:target="setGameCategorySlug, search"
            class="absolute inset-0 bg-bg-primary/70 flex flex-col items-center justify-center rounded-lg z-50 mx-4 lg:px-10"
        >
            <div class="relative flex items-center justify-center w-12 h-12">
                <div class="absolute w-12 h-12 border-4 border-purple-500/30 rounded-full"></div>
                <div class="absolute w-12 h-12 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
            <p class="text-sm text-purple-300 mt-3 font-medium tracking-wide">Loading content...</p>
        </div> --}}

        {{-- 🌟 Dropdown Content --}}
        <div class="dark:bg-zinc-600 bg-bg-primary flex flex-col lg:flex-row items-start justify-between rounded-lg shadow-lg  px-4 lg:px-10 min-h-[420px] overflow-y-auto" >
            
            {{-- Popular Games Section --}}
            <div class="w-full lg:w-2/3 pt-6 order-2 lg:order-1">
                <h3 class="text-text-white text-base font-semibold pt-2 mb-6">
                    Popular {{ ucfirst($gameCategorySlug) }}
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2.5">
                    @foreach($this->content['popular'] ?? [] as $item)
                        <a href="{{route('game.index', ['gameSlug' => $item['slug'], 'categorySlug' => $gameCategorySlug ])}}"  wire:navigate>
                            <div class="flex items-center gap-2.5 p-2.5 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                                <div class="w-6 h-6">
                                    <img src="{{ asset('assets/images/game_icon/' . $item['icon']) }}" 
                                        alt="{{ $item['name'] }}"
                                        class="w-full h-full object-contain">
                                </div>
                                <p class="text-base font-normal text-text-white">{{ $item['name'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Search and All Games Section --}}
            <div class="w-full lg:w-1/3 p-6 order-1 lg:order-2">
                <div class="mb-2">
                    <span class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search for {{ $gameCategorySlug }}" 
                            class="form-input w-full text-text-white dark:bg-bg-primary/30 bg-bg-secondary border border-purple-500/20 rounded-lg px-4 py-2 focus:outline-none focus:border-purple-500" 
                        />
                    </span>
                </div>
                
                <div class="space-y-2">
                    <p class="text-xs font-semibold text-text-white/70 px-2.5 uppercase tracking-wide">
                        All {{ ucfirst(str_replace('_', ' ', $gameCategorySlug)) }}
                    </p>
                    @foreach($this->content['all'] ?? [] as $item)
                        <p class="text-base font-normal text-text-white p-2.5 hover:bg-purple-500/10 rounded-lg transition cursor-pointer">
                            {{ $item }}
                        </p>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
