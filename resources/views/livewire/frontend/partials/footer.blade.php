<footer class="bg-bg-tertiary ">
    <div class="container py-12">
        <div class="grid grid-cols-3 md:grid-cols-5 gap-8">
            <!-- Brand Section -->
            <div class="col-span-3 md:col-span-2">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
                    <div
                        class="w-10 lg:w-14 h-10 lg:h-14 xl:w-16 xl:h-16 rounded-full btn-gradient flex items-center justify-center">
                        <span class="text-white font-bold text-lg lg:text-2xl xl:text-3xl">{{ __('DG') }}</span>
                    </div>
                    <span
                        class="text-lg lg:text-2xl xl:text-3xl font-bold font-playfair text-text-primary">{{ __('DiodioGlow') }}</span>
                </a>
                <p class="text-sm lg:text-base text-text-secondary mt-2 md:pr-50 leading-relaxed">
                    {{ __('Curating viral skincare trends and AI-powered product recommendations for natural, glowing skin.') }}
                </p>
            </div>

            <!-- Explore Section -->
            <div class="justify-center">
                <h3 class="text-text-primary font-playfair font-semibold text-lg mb-4">{{ __('Explore') }}</h3>
                <ul class="space-y-1">
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Home') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Videos') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Products') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Connect Section -->
            <div>
                <h3 class="text-text-primary font-playfair font-semibold text-lg mb-4">{{ __('Connect') }}</h3>
                <ul class="space-y-1">
                    <li><a href="https://tiktok.com" target="_blank" rel="noopener noreferrer"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('TikTok') }}</a>
                    </li>
                    <li><a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Instagram') }}</a>
                    </li>
                    <li><a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('YouTube') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Contact') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div>
                <h3 class="text-text-primary font-playfair font-semibold text-lg mb-4">{{ __('Legal') }}</h3>
                <ul class="space-y-1">
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Privacy Policy') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Terms of Service') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Affiliate Disclosure') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-orange-500 transition-colors text-sm lg:text-base">{{ __('Support') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
