<div class="pt-7 container">
    <div class="flex justify-between gap-6 items-center">
        <div class="w-full">
            <div class="w-sm bg-[#FBBA2A66] rounded-full py-2 px-4">
                <span class="text-xs text-[#696868] font-inter font-normal">
                    <flux:icon name="sun" class="w-6 h-6 inline mr-2.5" />{{ __('Trusted by 50K+ beauty lovers') }}
                </span>
            </div>
            <h3 class="text-8xl font-semibold font-montserrat text-[#D09003] my-6"><span
                    class="text-[#6B4A01]">{{ __('Glow') }}</span> {{ __('Naturally') }} </h3>
            <p class="text-xl font-medium font-inter">
                {{ __('Discover routines that actually work. Explore trending videos, shop vetted products, and get personalized advice tailored to your skin type.') }}
            </p>
            <div class="flex gap-4 mt-6">
                <div class="">
                    <x-ui.button href="#" class="w-auto py-2!">
                        {{ __('Back') }}
                        <flux:icon name="arrow-right"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    </x-ui.button>
                </div>
                <div class="">
                    <x-ui.button href="#" class="w-auto py-2!">
                        {{ __('Watch Stories') }}
                        <flux:icon name="play"
                            class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    </x-ui.button>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="w-[610px] h-[610px]">
                <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="" class="w-full h-full">
            </div>

        </div>
    </div>
</div>
