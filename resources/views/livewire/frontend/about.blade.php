<div>

    <section class="bg-gradient mb-12 sm:mb-0">
        {{-- Banner Section --}}
        <div class="container pt-20 pb-16 lg:pt-24">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-14">
                {{-- Image Section --}}
                <div class="w-full lg:w-1/2 flex justify-center relative">
                    @if ($banner && $banner->banner_video)
                        <!-- Video Container -->
                        <div class="relative w-full max-w-[500px] lg:max-w-none">
                            <!-- Video Element with Controls (Fixed Height for Matching Thumbnail) -->
                            {{-- poster="{{ asset('storage/' . $banner->thumbnail) }}" --}}
                            <video id="bannerVideo" controls
                                class="w-full h-[500px] lg:h-[600px] rounded-lg object-cover block">
                                <source src="{{ asset('storage/' . $banner->banner_video) }}" type="video/mp4">
                                {{ __('Your browser video support is not enough.') }}
                            </video>

                            <!-- Custom Play Button Overlay -->
                            <div id="playButton"
                                class="absolute inset-0 flex items-center justify-center cursor-pointer pointer-events-none">
                                <!-- Play Button Box (White Background) -->
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-xl pointer-events-auto"
                                    onclick="document.getElementById('bannerVideo').play();">
                                    <!-- Play Icon (Color: #D09003) -->
                                    <svg class="w-10 h-10 ml-1" fill="#D09003" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @else
                        <img src="{{ asset('assets/images/home_page/image 2.png') }}" alt="Banner image"
                            class="w-full max-w-[500px] lg:max-w-none h-auto rounded-lg object-cover block">
                    @endif
                </div>

                {{-- Text Content --}}
                <div class="w-full lg:w-1/2 lg:text-left">

                    <div>
                        <p class="text-xs font-normal text-muted font-inter pb-4 text-center lg:text-left">
                            {{ __('About Diodio Glow') }}</p>
                        {{-- Heading --}}
                        <h2
                            class="text-3xl font-bold font-montserrat text-second-800 pb-6 text-text-primary lg:text-left">
                            {{ (app()->getLocale() === 'en' ? $banner->title_en : $banner->title_fr) ?? __('Your Source for Viral Beauty Trends & Skincare Inspiration') }}
                        </h2>
                        {{-- Description --}}
                        <p class="text-base text-text-primary font-normal font-inter lg:text-left">
                            {{ (app()->getLocale() === 'en' ? $banner->description_en : $banner->description_fr) ?? __('Diodio Glow is a digital platform dedicated to showcasing the latest beauty trends, skincare routines, and viral content from across Senegal and the global beauty community. We curate, highlight, and organize the products, routines, and videos that people are already talking about—so you can easily explore what’s trending.') }}
                        </p>
                    </div>

                    <div class="pt-16">
                        <div class="flex gap-2 items-center lg:text-left">
                            <flux:icon name="check" class="w-6 h-6 stroke-second-50 bg-second-500 rounded-full" />
                            <p class="text-base text-text-primary font-semibold font-inter">
                                {{ __('50K+ followers across TikTok, Instagram & YouTube') }}</p>
                        </div>
                        <div class="flex gap-2 items-center pt-10 lg:text-left">
                            <flux:icon name="check" class="w-6 h-6 stroke-second-50 bg-second-500 rounded-full" />
                            <p class="text-base text-text-primary font-semibold font-inter">
                                {{ __('100+ curated products handpicked for quality and affordability') }}</p>
                        </div>
                        <div class="flex gap-2 items-center pt-10 lg:text-left">
                            <flux:icon name="check" class="w-6 h-6 stroke-second-50 bg-second-500 rounded-full" />
                            <p class="text-base text-text-primary font-semibold font-inter">
                                {{ __('95% satisfaction rate from product recommendations') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#fcf8f6] py-16 lg:py-28">
        <div class="container mx-auto text-center">
            <h2 class="text-5xl font-bold font-montserrat text-text-primary pb-8">
                {{ __('Connect with Diodio Glow') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">

                @php
                    $cardClasses =
                        'w-full bg-white py-8 px-6 rounded-2xl shadow-lg border border-[#fce8d7] transition-all duration-300 transform hover:shadow-xl hover:translate-y-[-4px] hover:border-[#ffe4e4]';
                    $titleClasses = 'text-2xl font-bold font-montserrat text-text-primary pt-3 pb-1';
                    $iconClasses = 'w-12 h-12 mx-auto';
                @endphp


                <a href="{{ route('blog') }}" wire:navigate class="{{ $cardClasses }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff86a2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                        <path d="M12 14v7"></path>
                        <path d="M3 21h18"></path>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Blog</h3>
                    <p class="text-sm text-gray-500">Read the latest tips</p>
                </a>

                <a href="{{ route('video-feed') }}" wire:navigate class="{{ $cardClasses }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff6a8f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 16v1a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v1"></path>
                        <path d="M10 12l8 5 0-10-8 5z"></path>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Video Feed</h3>
                    <p class="text-sm text-gray-500">Watch our tutorials</p>
                </a>

                <a href="{{ route('product') }}" wire:navigate class="{{ $cardClasses }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff7c9c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Products</h3>
                    <p class="text-sm text-gray-500">Shop our collection</p>
                </a>

                <a href="mailto:contact@diodioglow.com" class="{{ $cardClasses }} lg:max-w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClasses }}" viewBox="0 0 24 24"
                        fill="none" stroke="#ff98b1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <h3 class="{{ $titleClasses }}">Contact</h3>
                    <p class="text-sm text-gray-500">Send us an email</p>
                </a>

            </div>
        </div>
    </section>



    <section class="bg-gradient mb-12 sm:mb-0">
        <div class="container py-12">

            <h2 class="text-5xl font-bold font-montserrat pb-6 text-text-primary">
                {{ __('Our Mission') }}
            </h2>

            <p class="text-base font-normal font-inter text-muted">
                {{ __('make beauty discovery easier, enjoyable, and accessible for everyone.') }}
            </p>

            <p class="text-base font-normal font-inter text-muted mt-6">
                {{ __('Whether it’s a viral TikTok skincare hack, an African beauty routine, or a popular product review, Diodio Glow brings everything together in one place. We focus on spotlighting authentic routines, diverse skin needs, and the beauty content people love to watch.') }}
            </p>

            <p class="text-base font-normal font-inter text-muted mt-6">
                {{ __('This platform is powered by community-driven trends, curated recommendations, and quality-driven product selections designed to help you find what works for your skin.') }}
            </p>

            <hr class="my-10 border-gray-300" />

            <!-- New content added from AI image text -->
            <h3 class="text-3xl font-bold font-montserrat pb-4 text-text-primary">
                {{ __('What You’ll Find on Diodio Glow') }}
            </h3>

            <ul class="list-disc pl-6 text-base font-inter text-muted space-y-2">
                <li>{{ __('Curated viral beauty videos & routines from Senegal and beyond') }}</li>
                <li>{{ __('Product discoveries and reviews organized for easy browsing') }}</li>
                <li>{{ __('Beauty insights, trends, and articles focused on real results') }}</li>
                <li>{{ __('A growing library of content shaped by what people are searching and sharing') }}</li>
            </ul>

            <p class="text-base font-normal font-inter text-muted mt-8">
                {{ __('Our goal is to make Diodio Glow one of the leading online destinations for beauty inspiration—not an influencer, but a platform that brings together the best of beauty, culture, and skincare trends.') }}
            </p>

            <h3 class="text-3xl font-bold font-montserrat pb-4 mt-10 text-text-primary">
                {{ __('Your Source for Viral Beauty Trends & Skincare Inspiration') }}
            </h3>

            <p class="text-base font-normal font-inter text-muted">
                {{ __('Diodio Glow is a digital platform dedicated to showcasing the latest beauty trends, skincare routines, and viral content from across Senegal and the global beauty community. We curate, highlight, and organize the products, routines, and videos that people are already talking about—so you can easily explore what’s trending.') }}
            </p>

            <p class="text-base font-normal font-inter text-muted mt-6">
                {{ __('Our mission is simple: make beauty discovery easier, enjoyable, and accessible for everyone.') }}
            </p>

            <p class="text-base font-normal font-inter text-muted mt-6">
                {{ __('Whether it’s a viral TikTok skincare hack, an African beauty routine, or a popular product review, Diodio Glow brings everything together in one place. We focus on spotlighting authentic routines, diverse skin needs, and the beauty content people love to watch.') }}
            </p>

            <p class="text-base font-normal font-inter text-muted mt-6">
                {{ __('This platform is powered by community-driven trends, curated recommendations, and quality-driven product selections designed to help you find what works for your skin.') }}
            </p>

        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const video = document.getElementById('bannerVideo');
                const playButton = document.getElementById('playButton');

                // Video play হলে custom button hide করবে
                video.addEventListener('play', function() {
                    playButton.style.display = 'none';
                });

                // Video pause হলে custom button আবার show করবে
                video.addEventListener('pause', function() {
                    if (video.currentTime > 0 && !video.ended) {
                        playButton.style.display = 'flex';
                    }
                });

                // Video শেষ হলে custom button আবার show করবে
                video.addEventListener('ended', function() {
                    playButton.style.display = 'flex';
                });
            });
        </script>
    @endpush
</div>
