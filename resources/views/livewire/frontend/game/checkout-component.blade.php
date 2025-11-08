<section class="mx-auto">
    <div class="container mx-auto">
        <div class="flex items-center gap-2 my-8 text-lg font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <h1 class="text-blue-100 text-text-primary">
                {{ucwords(str_replace('-', ' ', $gameSlug)) . ' '. ucwords(str_replace('-', ' ', $categorySlug))}}
            </h1>
            <span class=" text-text-primary">></span>
            <span class=" text-text-primary">Checkout</span>
        </div>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-[60%]">
                <div class="p-4 md:p-10 bg-bg-primary rounded-2xl">
                    <div class="flex gap-6">
                        <div class="w-14 h-14">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks3.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="">
                            <h2 class="text-text-white text-xl font-normal"><span
                                    class="text-text-white text-xl font-bold">{{ __('V-Bucks') }} </span>{{__('Fast, cheap pro boost.Any
                                brawler, any trophies...')}}</h2>
                            <span class="text-text-white text-sm">{{__('Brawl Stars - Boosting')}}</span>
                            <div class="flex justify-end gap-8 mt-5">
                                <h3 class="text-text-white text-xl ">*1</h3>
                                <h3 class="text-text-white text-2xl font-semibold"> $76.28</h3>
                            </div>

                        </div>
                    </div>
                    <span class="border-t-2 border-zinc-500 w-full inline-block"></span>
                </div>
                <div class="bg-bg-primary p-6 md:p-10 rounded-2xl mt-7">
                    <h2 class="text-text-white text-2xl font-semibold">{{__('Contact information')}}</h2>
                    <form action="">
                        <div class="mt-4">
                            <div class="">
                                <x-ui.input placeholder="Email address*" />
                            </div>
                            <div class="mt-4">
                                <x-ui.input placeholder="Phone Number*" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-full md:w-[40%] bg-bg-primary py-7 px-6 rounded-2xl">
                <div class="mb-3">
                    <h2 class="text-2xl font-semibold">{{__('Cart Total')}}</h2>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{__('Cart Subtotal')}}</p>
                    <p class="text-text-white text-base font-semibold">$76.28</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{__('Payment fee')}}</p>
                    <p class="text-text-white text-base font-semibold">+0.79</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{__('Discount')}}</p>
                    <p class="text-text-white text-base font-semibold">-$00</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{__('Cart Total')}}</p>
                    <p class="text-text-white text-base font-semibold">$77.07</p>
                </div>
                <div class="mt-8 py">
                    <x-ui.button href="{{ route('game.checkout',['orderId'=>435345]) }}" class="w-auto py-3!">{{__('$76.28 | Buy now')}}
                    </x-ui.button>
                </div>
                <div class="mt-8">
                    <input type="checkbox" name="" id=""  class="accent-zinc-500 rounded-full">
                    <label for="" class="text-text-white text-base ">{{__('I accept the Terms of Service , Privacy
                        Notice and Refund Policy.')}}</label>
                </div>
            </div>
        </div>
    </div>
    <section class="mx-auto">
    <div class="container mx-auto">
        <div class="flex items-center gap-2 my-8 text-lg font-semibold">
            <div class="w-4 h-4">
                <img src="{{ asset('assets/images/items/1.png') }}" alt="m logo" class="w-full h-full object-cover">
            </div>
            <h1 class="text-blue-100 text-text-primary">
                {{ucwords(str_replace('-', ' ', $gameSlug)) . ' '. ucwords(str_replace('-', ' ', $categorySlug))}}
            </h1>
            <span class=" text-text-primary">></span>
            <span class=" text-text-primary">{{ __('Checkout') }}</span>
        </div>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-[60%]">
                <div class="p-4 md:p-10 bg-bg-primary rounded-2xl">
                    <div class="flex gap-6">
                        <div class="w-14 h-14">
                            <img src="{{ asset('assets/images/gift_cards/V-Bucks3.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="">
                            <h2 class="text-text-white text-xl font-normal"><span
                                        class="text-text-white text-xl font-bold">{{ __('V-Bucks') }} </span>{{ __('Fast, cheap pro boost. Any brawler, any trophies...') }}</h2>
                            <span class="text-text-white text-sm">{{ __('Brawl Stars - Boosting') }}</span>
                            <div class="flex justify-end gap-8 mt-5">
                                <h3 class="text-text-white text-xl ">{{ __('*1') }}</h3>
                                <h3 class="text-text-white text-2xl font-semibold"> {{ __('$76.28') }}</h3>
                            </div>

                        </div>
                    </div>
                    <span class="border-t-2 border-zinc-500 w-full inline-block"></span>
                </div>
                <div class="bg-bg-primary p-6 md:p-10 rounded-2xl mt-7">
                    <h2 class="text-text-white text-2xl font-semibold">{{ __('Contact information') }}</h2>
                    <form action="">
                        <div class="mt-4">
                            <div class="">
                                <x-ui.input placeholder="{{ __('Email address*') }}" />
                            </div>
                            <div class="mt-4">
                                <x-ui.input placeholder="{{ __('Phone Number*') }}" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-full md:w-[40%] bg-bg-primary py-7 px-6 rounded-2xl">
                <div class="mb-3">
                    <h2 class="text-2xl font-semibold">{{ __('Cart Total') }}</h2>
                </div>
                <div class="flex justify-between mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Subtotal') }}</p>
                    <p class="text-text-white text-base font-semibold">{{ __('$76.28') }}</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{ __('Payment fee') }}</p>
                    <p class="text-text-white text-base font-semibold">{{ __('+0.79') }}</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{ __('Discount') }}</p>
                    <p class="text-text-white text-base font-semibold">{{ __('-$00') }}</p>
                </div>
                <div class="flex justify-between  mb-3">
                    <p class="text-text-white text-sm">{{ __('Cart Total') }}</p>
                    <p class="text-text-white text-base font-semibold">{{ __('$77.07') }}</p>
                </div>
                <div class="mt-8 py">
                    <x-ui.button href="{{ route('game.checkout',['orderId'=>435345]) }}" class="w-auto py-3!">{{ __('$76.28 | Buy now') }}
                    </x-ui.button>
                </div>
                <div class="mt-8">
                    <input type="checkbox" name="" id=""  class="accent-zinc-500 rounded-full">
                    <label for="" class="text-text-white text-base ">{{ __('I accept the Terms of Service, Privacy Notice and Refund Policy.') }}</label>
                </div>
            </div>
        </div>
    </div>

    {{-- payment methoad --}}
<div class="container mx-auto mt-10 mb-40">
    <div class="bg-bg-primary p-4 md:p-10 rounded-2xl">
        <h2 class="text-text-white text-2xl font-semibold mb-6">{{ __('Payment method') }}</h2>
        <div class="">
            <form action="">
                <div class="flex items-center justify-between gap-4 border border-zinc-500 rounded-2xl py-5 px-6">
                    <div class="flex items-center gap-2">
                        <div class="w-12 h-5">
                            <img src="{{ asset('assets/images/gift_cards/Visa.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-5 h-5">
                            <img src="{{ asset('assets/images/gift_cards/mastercard.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-5 h-5">
                            <img src="{{ asset('assets/images/gift_cards/Frame 1261154336.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-5 h-5">
                            <img src="{{ asset('assets/images/gift_cards/a.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-16 h-5">
                            <img src="{{ asset('assets/images/gift_cards/Frame 1 (1).png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="text-text-white hidden md:block">{{ __('Credit/Debit Card') }}</p>
                        <input type="checkbox" name="" id=""
                            class="scale-150 accent-zinc-500 rounded-full">
                    </div>
                </div>
                <div
                    class="flex items-center justify-between gap-4 border border-zinc-500 rounded-2xl py-5 px-6 mt-6">
                    <div class="flex items-center gap-2">
                        <div class="w-11 h-7">
                            <img src="{{ asset('assets/images/gift_cards/google2.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-11 h-7">
                            <img src="{{ asset('assets/images/gift_cards/apple2.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="text-text-white hidden md:block">{{ __('Digital Wallet') }}</p>
                        <input type="checkbox" name="" id=""
                            class="scale-150 accent-zinc-500 rounded-full">
                    </div>
                </div>
                <div
                    class="flex items-center justify-between gap-4 border border-zinc-500 rounded-2xl py-5 px-6 mt-6">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/Crypto1.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/Crypto2.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/Crypto3.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/Crypto4.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                        <div class="w-6 h-6">
                            <img src="{{ asset('assets/images/gift_cards/Crypto4.png') }}" alt=""
                                class="w-full h-full">
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="text-text-white hidden md:block">{{ __('Crypto') }}</p>
                        <input type="checkbox" name="" id=""
                            class="scale-150 accent-zinc-500 rounded-full">
                    </div>
                </div>
                <div class="form-group">
                    <x-ui.input placeholder="{{ __('Card number*') }}" class="mt-6" />
                </div>
                <div class="flex items-center justify-between gap-6">
                    <div class="form-group w-full">
                        <x-ui.input placeholder="{{ __('vali date*') }}" class="mt-6" />
                    </div>
                    <div class="form-group w-full">
                        <x-ui.input placeholder="{{ __('CVC*') }}" class="mt-6" />
                    </div>
                </div>
                <div class="form-group">
                    <x-ui.button type="submit" class="mt-10 w-full! md:w-sm! py-3!">{{ __('Save Payment Method') }}</x-ui.button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
