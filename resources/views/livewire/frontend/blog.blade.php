<div class="bg-gradient">
    <div class="container px-0 lg:px-24 pb-0 sm:pb-24 py-12">
        <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center">{{ __('Blog') }}</h2>

        @foreach ($blogs as $index => $blog)
            @php $layout = $index % 2; @endphp

            @if ($layout === 0)
                <div class="block lg:flex gap-12 items-center justify-between mt-12">
                    <div class="bg-second-500/15 p-6 lg:w-1/2">
                        <h3 class="text-3xl font-semibold text-text-primary">
                            {{ Str::words($blog->title, 4, '..') }}
                        </h3>
                        <a href="{{ route('blog.details', [$blog->slug]) }}" wire:navigate
                            class="block mt-4 text-text-secondary">
                            {!! Str::words($blog->description, 50, '...') !!}
                        </a>
                    </div>
                    <div class="lg:w-1/2 mt-8 lg:mt-0 flex justify-center">
                        <x-blog-media :file="$blog->file"
                            class="!object-cover w-full h-full sm:max-w-[450px] sm:max-h-[600px]" />
                    </div>
                </div>
            @endif

            @if ($layout === 1)
                <div class="block lg:flex gap-12 items-center justify-between mt-12 lg:mt-20">
                    <div class="lg:w-1/2 flex justify-center">
                        <x-blog-media :file="$blog->file"
                            class="!object-cover w-full h-full sm:max-w-[450px] sm:max-h-[600px]" />
                    </div>
                    <div class="bg-blog p-6 lg:w-1/2 mt-8 lg:mt-0">
                        <h3 class="text-3xl font-semibold text-text-primary">
                            {{ Str::words($blog->title, 4, '..') }}
                        </h3>
                        <a href="{{ route('blog.details', [$blog->slug]) }}" wire:navigate
                            class="block mt-4 text-text-secondary">
                            {!! Str::words($blog->description, 50, '...') !!}
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
