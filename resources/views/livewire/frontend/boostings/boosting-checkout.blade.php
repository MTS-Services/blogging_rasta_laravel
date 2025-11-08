<div>
    <div class="bg-gradient-to-br  min-h-screen p-8">
        <div class="max-w-7xl mx-auto">
             <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-8 text-sm">
                <span class="text-blue-100 text-text-primary">
                    <img width="25" class="inline-block" src="{{ asset('assets/images/mdb.png') }}" alt="img">
                    {{__('Blade ball tokens')}}</span>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">{{__('Seller list')}}</span>
                <span class=" text-text-primary">></span>
                <span class=" text-text-primary">{{__('Checkout')}}</span>
            </div>
            <!-- Main Container -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Forms -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Product Section -->
                    <div class="bg-bg-primary rounded-lg p-4">
                        <div class="flex items-center justify-between border-b border-purple-700 p-4">
                            <div class="flex items-center gap-4">
                                <div class=" rounded-full flex items-center justify-center  ">
                                    <img class="w-18 h-16" src="{{ asset('assets/images/fc_coins.png.png') }}"
                                        alt="">
                                </div>
                                <div>
                                    <h3 class="text-text-primary font-medium text-xl">{{ __('EA SPORTS FC COINS') }} <span
                                            class="text-text-primary text-sm">{{__('Fast, cheap pro boost. Any brawler,
                                            a')}}</span>
                                    </h3>

                                    <p class="text-text-primary text-xs mt-1">{{__('Brand Stars • Boosting')}}</p>
                                </div>
                            </div>
                            <div class="float-right pt-18 ">
                                <div class="flex items-center gap-5 mb-2">
                                    <span class="text-text-primary">{{__('*1')}}</span>
                                    <span class="text-text-primary text-2xl ">{{__('$76.28')}}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Contact Information -->
                    <div class="bg-bg-primary rounded-lg p-6">
                        <h2 class="text-text-primary text-xl mb-6">{{__('Contact information')}}</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-text-primary text-sm mb-2"></label>
                                <input type="email" placeholder="Email address"
                                    class="w-full  border border-purple-700/50 rounded-lg px-4 py-3 dark:placeholder-purple-100   focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500  ">
                            </div>
                            <div>
                                <label class="block text-text-primary text-sm mb-2"> </label>
                                <input type="tel" placeholder="Phone number"
                                    class="w-full  border border-purple-700/50 rounded-lg px-4 py-3 dark:placeholder-purple-100   focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                            </div>
                        </div>
                    </div>


                </div>


                <!-- Right Column - Cart Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-bg-primary rounded-lg p-6 top-8">
                        <h2 class="text-text-primary text-xl mb-6">{{__('Cart Total')}}</h2>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-text-primary">{{__('Cart Subtotal')}}</span>
                                <span class="text-text-primary  ">{{__('$76.28')}}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-text-primary">{{__('Shipping')}}</span>
                                <span class="text-text-primary  ">{{__('+0.79')}}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-text-primary">{{__('Discount')}}</span>
                                <span class="text-text-primary ">{{__('-$90')}}</span>
                            </div>
                            <div class="border-t border-purple-700/50 pt-4 flex justify-between items-center">
                                <span class="text-text-primary ">{{__('Cart Total')}}</span>
                                <span class="text-text-primary text-2xl ">{{__('$77.07')}}</span>
                            </div>
                        </div>

                        <!-- Pay Now Button -->
                        <button
                            class="w-full bg-[#853EFF] text-white text-xl py-3 rounded-full transition transform hover:scale-105 mb-4">
                            {{__('$77.07 | Pay Now')}}
                        </button>

                        <!-- Terms Checkbox -->
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" checked class="w-5 h-5 mt-1 accent-[#853EFF]">
                            <span class="text-purple-300 text-sm">
                                {{__('I accept the')}} <span class="text-purple-200 hover:text-white">{{__('Terms of Service')}}</span>,
                                <span class="text-purple-200 hover:text-white">{{__('Privacy Notice')}}</span> {{ __('and') }} <span
                                    class="text-purple-200 hover:text-white">{{__('Refund Policy .')}}</span>
                            </span>
                        </label>
                    </div>
                </div>

            </div>
            <!-- Payment Method -->
            <div class="bg-bg-primary rounded-lg p-6 w-full mt-5">
                <h2 class="text-text-primary text-xl mb-6">{{__('Payment method')}}</h2>
                <div class="space-y-3">
                    <!-- Credit/Debit Card Option -->
                    <label
                        class="flex items-center p-4 border-2 border-purple-900/20 rounded-lg cursor-pointer hover:bg-purple-900/30 transition">

                        <div class="flex-1 ml-4 flex items-center justify-between">
                            <span class="text-purple-300 text-sm"><img
                                    src="{{ asset('assets/images/CreditDebit Card.png') }}" alt=""></span>
                            <div class="flex items-center gap-2">
                                <span class="text-text-primary">{{__('Credit/Debit Card')}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18"
                                    class="fill-white bg-[#853EFF] rounded-full" viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>

                            </div>
                        </div>
                    </label>

                    <label
                        class="flex items-center p-4 border-2 border-purple-900/20 rounded-lg cursor-pointer hover:bg-purple-900/30 transition">

                        <div class="flex-1 ml-4 flex items-center justify-between">
                            <span class="text-purple-300 text-sm"><img
                                    src="{{ asset('assets/images/Digital Wallet.png') }}" alt=""></span>
                            <div class="flex items-center gap-2">
                                <span class="text-text-primary">{{__('Digital Wallet')}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18"
                                    class="fill-white bg-[#853EFF] rounded-full" viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>

                            </div>
                        </div>
                    </label>

                    <label
                        class="flex items-center p-4 border-2 border-purple-900/20 rounded-lg cursor-pointer hover:bg-purple-900/30 transition">

                        <div class="flex-1 ml-4 flex items-center justify-between">
                            <span class="text-purple-300 text-sm"><img src="{{ asset('assets/images/Crypto.png') }}"
                                    alt=""></span>
                            <div class="flex items-center gap-2">
                                <span class="text-text-primary">{{__('Crypto')}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18"
                                    class="fill-white bg-[#853EFF] rounded-full" viewBox="0 0 256 256">
                                    <path
                                        d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>

                            </div>
                        </div>
                    </label>
                </div>

                <!-- Card Details -->
                <div class="mt-8 space-y-4">
                    <div>
                        <input type="text" placeholder="Card number*"
                            class="w-full bg-bg-primary border border-purple-700/50 rounded-lg px-4 py-3   dark:placeholder-purple-100 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <input type="text" placeholder="vali date*"
                                class="w-full bg-bg-primary  border border-purple-700/50 rounded-lg px-4 py-3   dark:placeholder-purple-100 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                        </div>
                        <div>
                            <input type="text" placeholder="CVC*"
                                class="w-full  border border-purple-700/50 rounded-lg px-4 py-3 dark:placeholder-purple-100   focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Save Payment Method Button -->
                <button
                    class="mt-8  bg-[#853EFF] text-white text-lg py-3 px-6 rounded-full transition transform hover:scale-105">
                    {{__('Save Payment Method')}}
                </button>
            </div>
        </div>


    </div>
</div>
