<div class="flex gap-6 items-start">

    <a wire:navigate href="profile" class="flex flex-col items-center">
        <div class="w-[60px] h-[60px] mb-2 {{ request()->is('profile') ? 'bg-zinc-500' : 'bg-zinc-800' }} b rounded-xl flex items-center justify-center">
            <img src="{{ asset('assets/images/user_profile/vector.png') }}" alt="Currency Icon"
                class="w-[30px] h-[30px] object-contain">
        </div>
        <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">{{__('Currency (0)')}}</h3>
    </a>

    <a wire:navigate href="account" class="flex flex-col items-center">
        <div class="w-[60px] h-[60px] mb-2 {{ request()->is('account') ? 'bg-zinc-500' : 'bg-zinc-800' }} rounded-xl flex items-center justify-center">
            <img src="{{ asset('assets/images/user_profile/download (4) 1.png') }}" alt="Account Icon"
                class="w-[30px] h-[30px] object-contain">
        </div>
        <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">{{__('Account (0)')}}</h3>
    </a>

    <a href="#" class="flex flex-col items-center">
        <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
            <img src="{{ asset('assets/images/user_profile/download 1.png') }}" alt="Items Icon"
                class="w-[30px] h-[30px] object-contain">
        </div>
        <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">{{__('Items (0)')}}</h3>
    </a>

    <a href="#" class="flex flex-col items-center">
        <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
            <img src="{{ asset('assets/images/user_profile/download (2) 1.png') }}" alt="Top Ups Icon"
                class="w-[30px] h-[30px] object-contain">
        </div>
        <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">{{__('Top Ups (0)')}}</h3>
    </a>

    <a href="#" class="flex flex-col items-center">
        <div class="w-[60px] h-[60px] mb-2 bg-zinc-800 rounded-xl flex items-center justify-center">
            <img src="{{ asset('assets/images/user_profile/download (1) 1.png') }}" alt="Gift Cards Icon"
                class="w-[30px] h-[30px] object-contain">
        </div>
        <h3 class="text-sm font-medium text-zinc-50 whitespace-nowrap">{{__('Gift Cards (0)')}}</h3>
    </a>

</div>
