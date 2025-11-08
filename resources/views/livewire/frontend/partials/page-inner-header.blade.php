<header class=" sm:py-4 sm:px-8 lg:py-0 lg:px-0">
    <div class=" text-white lg:px-18 md:px-0">
        <div
            class="max-w-[1200px] mx-auto flex flex-col md:flex-row gap-4 md:items-center justify-between w-full sm:px-6 sm:py-6 lg:py-0 lg:px-0 mt-4">
            <!-- Logo -->
            <div class="flex gap-8">
                <div class="h-8 w-8 bg-orange-500 rounded flex items-center justify-center font-medium">
                    <img src="{{ asset('assets/images/fortnite.png') }}" alt="">
                </div>
                <span class="text-xl font-medium">{{ucfirst(str_replace('-', ' ', $gameSlug))}}</span>
            </div>
            <!-- Navigation Links -->
            <nav
                class="py-2 peer-checked:flex flex-col lg:flex lg:flex-row gap-8 w-full lg:w-auto  lg:bg-transparent border-t  lg:border-none">
                @foreach (gameCategories() as $category)
                        <a href="{{ route('game.index', ['gameSlug' => $gameSlug, 'categorySlug' => $category['slug']]) }}" wire:navigate class="navbar_style {{ $categorySlug == $category['slug'] ? 'active' : 'text-text-primary' }}">{{$category['name']}}</a>
                @endforeach
                {{-- <a href="{{route('game.index', ['game-category' => 'currency', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'currency' ? 'active' : 'text-text-primary'}}">Currency</a>
                <a href="{{route('game.index', ['game-category' => 'gift-cards', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'gift-cards' ? 'active' : 'text-text-primary'}}">Gift Card</a>
                <a href="{{route('game.index', ['game-category' => 'boosting', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'boosting' ? 'active' : 'text-text-primary'}}">Boosting</a>
                <a href="{{route('game.index', ['game-category' => 'items', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'items' ? 'active' : 'text-text-primary'}}">Items</a>
                <a href="{{route('game.index', ['game-category' => 'accounts', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'accounts' ? 'active' : 'text-text-primary'}}">Accounts</a>
                <a href="{{route('game.index', ['game-category' => 'topups', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'topups' ? 'active' : 'text-text-primary'}}">Top Ups</a>
                <a href="{{route('game.index', ['game-category' => 'coaching', 'slug' => $gameSlug])}}" wire:navigate class="navbar_style {{request()->has('game-category') && request()->get('game-category') == 'coaching' ? 'active' : 'text-text-primary'}}">Coaching</a> --}}
            </nav>
        </div>
    </div>
</header>
