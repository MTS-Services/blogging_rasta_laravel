<div>
    <div class="container bg-gradient px-0 lg:px-24 pb-0 sm:pb-24 my-12 ">
        <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center">{{ __('Blog') }}</h2>

        {{-- Trending Routines --}}
        <div class="block lg:flex gap-12 items-center justify-between mt-7">
            <div class="bg-second-500/15 p-6">
                <h3 class="text-3xl font-semibold font-montserrat text-text-primary">{{ __('Trending Routines: ') }}</h3>

                <div class="mt-6">
                    <a wire:navigate href="{{ route('blog.details') }}">
                        <h6 class="text-base font-semibold font-inter text-text-primary">
                            {{ __('1. The “Glass Skin” Routine') }}</h6>

                        <p class="text-base font-normal font-inter text-text-primary mt-2">
                            {{ __('Originating from Korean beauty, the glass skin trend is all about achieving a complexion that’s smooth, clear, and luminous—just like glass.') }}
                        </p>

                        <p class="text-base font-normal font-inter text-text-primar mt-2">{{ __('How it works:') }}</p>
                        <ul class="text-base font-normal font-inter text-text-primar list-disc pl-5 mt-2">
                            <li class="text-base font-normal font-inter text-text-primar">
                                {{ __('Double cleanse to remove every trace of dirt and makeup') }}</li>
                            <li class="text-base font-normal font-inter text-text-primar">
                                {{ __('Apply hydrating toners and serums (look for hyaluronic acid)') }}</li>
                            <li class="text-base font-normal font-inter text-text-primar">
                                {{ __('Seal it all in with a lightweight moisturizer and sunscreen') }}</li>
                        </ul>
                        <P class="text-base font-normal font-inter text-text-primar mt-2">{{ __('Why it’s trending:') }}
                        </P>
                        <P class="text-base font-normal font-inter text-text-primar">
                            {{ __(' It delivers that natural, dewy glow everyone’s chasing—no filters needed.') }}</P>
                    </a>

                </div>
            </div>
            <div class="mx-auto mt-12 lg:mt-0 lg:mx-0">
                <div class="w-auto sm:w-[600px] h-auto sm:h-[912px]  text-center mx-auto">
                    <img src="{{ asset('assets/images/blog_page/image 5.png') }}" alt="Trending Routines"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        {{-- Product Reviews:  --}}
        <div class="block lg:flex gap-12 items-center justify-between mt-20">
            <div class="mx-auto lg:mx-0">
                <div class="w-auto sm:w-[600px] h-auto sm:h-[600px] text-center mx-auto">
                    <img src="{{ asset('assets/images/blog_page/image 6.png') }}" alt="Trending Routines"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <div class="bg-second-500/15 p-6 mt-12 lg:mt-0">
                <h3 class="text-3xl font-semibold font-montserrat text-text-primary">{{ __('Product Reviews: ') }}</h3>

                <div class="mt-6">
                    <p class="text-base font-normal font-inter text-text-primary">
                        {{ __('The beauty world is flooded with new products every week—serums that promise a glow-up overnight, moisturizers that claim 72-hour hydration, and toners that “transform” your skin...') }}
                    </p>
                </div>
            </div>
        </div>



        {{-- Tips & Guides:   --}}
        <div class="block lg:flex gap-12 items-center justify-between mt-20">
            <div class="bg-blog p-6">
                <h3 class="text-3xl font-semibold font-montserrat text-text-primary">{{ __('Tips & Guides: ') }}</h3>

                <div class="mt-6">
                    <p class="text-base font-normal font-inter text-text-primary">
                        {{ __('In our fast-paced world, having access to the right advice can make all the difference. Whether it’s mastering a new skill, optimizing your daily routine, or navigating technology, practical tips and comprehensive guides can help you save time, avoid mistakes, and achieve your goals faster. In this blog, we’ll explore the essence of effective tips and guides and share some actionable strategies you can implement today.') }}
                    </p>
                </div>
            </div>
            <div class="mx-auto lg:mx-0 mt-12 lg:mt-0">
                <div class="w-auto sm:w-[600px] h-auto sm:h-[1080px] text-center mx-auto">
                    <img src="{{ asset('assets/images/blog_page/image 7.png') }}" alt="Trending Routines"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>

    </div>
</div>
