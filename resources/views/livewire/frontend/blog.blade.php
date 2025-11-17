<div class="bg-gradient">
    <div class="container px-0 lg:px-24 pb-0 sm:pb-24 py-12">
        <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center">{{ __('Blog') }}</h2>

        @foreach ($blogs as $index => $blog)
            @php $layout = $index % 2; @endphp

            @if ($layout === 0)
                <div class="flex gap-12 items-center justify-between mt-12">
                    <div class="bg-second-500/15 p-6 flex-1 lg:flex-1/2">
                        <h3 class="text-3xl font-semibold text-text-primary">{{ Str::limit($blog->title, 18, '..') }}
                        </h3>
                        <a href="{{ route('blog.details', $blog->slug) }}" wire:navigate
                            class="inline-block mt-4 text-text-secondary">
                            <div>
                                {!! Str::limit($blog->description, 800, '...') !!}
                            </div>
                        </a>
                    </div>
                    <div class="flex-1 lg:flex-1/2 mt-8 lg:mt-0 flex justify-center">
                        <x-blog-media :file="$blog->file" class="!object-cover" />
                    </div>
                </div>
            @endif

            @if ($layout === 1)
                <div class="flex gap-12 items-center justify-between mt-12 lg:mt-20">
                    <div class="flex-1 lg:flex-1/2 flex justify-center">
                        <x-blog-media :file="$blog->file" class="!object-cover " />
                    </div>
                    <div class="bg-blog p-6 flex-1 lg:flex-1/2 mt-8 lg:mt-0">
                        <h3 class="text-3xl font-semibold text-text-primary">{{ Str::limit($blog->title, 18, '..') }}
                        </h3>
                        <a href="{{ route('blog.details', $blog->slug) }}" wire:navigate
                            class="inline-block mt-4 text-text-secondary">
                            <div>
                                {!! Str::limit($blog->description, 800, '...') !!}
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
