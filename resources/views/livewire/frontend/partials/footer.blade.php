<footer class="bg-bg-tertiary">
    <div class="container px-4 py-10 sm:py-12">
        <div class="grid grid-cols-3 xxs:grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 sm:gap-8">
            <!-- Brand Section -->
            <div class="col-span-3 md:col-span-2">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 sm:gap-3">
                    <div
                        class="w-8 h-8 xxs:w-10 xxs:h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 xl:w-16 xl:h-16 rounded-full btn-gradient flex items-center justify-center">
                        <span
                            class="text-white font-bold text-xl lg:text-2xl xl:text-3xl">{{ __('DG') }}</span>
                    </div>
                    <span
                        class="text-xl lg:text-2xl xl:text-3xl font-bold font-playfair text-text-primary">{{ __('DiodioGlow') }}</span>
                </a>
                <p
                    class="text-xs xxs:text-sm sm:text-base text-text-secondary mt-2 sm:mt-3 md:pr-10 lg:pr-20 xl:pr-50 leading-relaxed">
                    {{ __('Curating viral skincare trends and AI-powered product recommendations for natural, glowing skin.') }}
                </p>
            </div>

            <!-- Explore Section -->
            <div class="col-span-1">
                <h3 class="text-text-primary font-playfair font-semibold text-base sm:text-lg mb-3 sm:mb-4">
                    {{ __('Explore') }}
                </h3>
                <ul class="space-y-1">
                    <li><a href="#"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Home') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Videos') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Products') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Connect Section -->
            <div class="col-span-1">
                <h3 class="text-text-primary font-playfair font-semibold text-base sm:text-lg mb-3 sm:mb-4">
                    {{ __('Connect') }}
                </h3>
                <ul class="space-y-1">
                    <li><a href="https://tiktok.com" target="_blank" rel="noopener noreferrer"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('TikTok') }}</a>
                    </li>
                    <li><a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Instagram') }}</a>
                    </li>
                    <li><a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('YouTube') }}</a>
                    </li>
                    <li><a href="#"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Contact') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div class="col-span-1">
                <h3 class="text-text-primary font-playfair font-semibold text-base sm:text-lg mb-3 sm:mb-4">
                    {{ __('Legal') }}
                </h3>
                <ul class="space-y-1">
                    <li><a href="{{ route('PrivacyPolicy') }}"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Privacy Policy') }}</a>
                    </li>
                    <li><a href="{{ route('TermsOfService') }}"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Terms of Service') }}</a>
                    </li>
                    <li><a href="{{ route('affiliate') }}"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Affiliate Disclosure') }}</a>
                    </li>
                    <li><a href="{{ route('support') }}"
                            class="text-text-secondary hover:text-second-500 transition-colors text-sm sm:text-base">{{ __('Support') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
