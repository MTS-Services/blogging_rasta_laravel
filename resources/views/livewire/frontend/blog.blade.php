<div class="bg-gradient">
    <div class="container px-0 lg:px-24 pb-0 sm:pb-24 py-12">
        <h2 class="text-4xl md:text-5xl font-bold font-montserrat text-text-primary text-center">{{ __('Blog') }}</h2>

        @foreach ($blogs as $index => $blog)
            @php $layout = $index % 2; @endphp

            {{-- LAYOUT: 0 --}}
            @if ($layout === 0)
                <div class="block lg:flex gap-12 items-center justify-between mt-12">
                    <div class="bg-second-500/15 p-6 lg:w-1/2">
                        <h3 class="text-3xl font-semibold text-text-primary">{{ $blog->title }}:</h3>

                        <p class="text-base mt-4 text-text-primary">
                            {!! \Illuminate\Support\Str::limit(($blog->description), 745, '...') !!}
                        </p>
                    </div>

                    <div class="lg:w-1/2 mt-8 lg:mt-0">
                        <div class="w-auto sm:w-[450px] h-auto sm:h-[600px] mx-auto">
                            <x-blog-media :file="$blog->file" />
                        </div>
                    </div>
                </div>
            @endif



            {{-- LAYOUT: 1 --}}
            @if ($layout === 1)
                <div class="block lg:flex gap-12 items-center justify-between mt-20">
                    <div class="lg:w-1/2">
                        <div class="w-auto sm:w-[450px] h-auto sm:h-[600px] mx-auto">
                            <x-blog-media :file="$blog->file" />
                        </div>
                    </div>

                    <div class="bg-blog p-6 lg:w-1/2 mt-8 lg:mt-0">
                        <h3 class="text-3xl font-semibold text-text-primary">{{ $blog->title }}:</h3>
                         {!! \Illuminate\Support\Str::limit(($blog->description), 745, '...') !!}
                    </div>
                </div>
            @endif


            {{-- LAYOUT: 2 --}}
            @if ($layout === 2)
                <div class="block lg:flex gap-12 items-center justify-between mt-20">
                    <div class="bg-blog p-6 lg:w-1/2">
                        <h3 class="text-3xl font-semibold text-text-primary">{{ $blog->title }}</h3>
                         {!! \Illuminate\Support\Str::limit(($blog->description), 745, '...') !!}
                    </div>

                    <div class="lg:w-1/2 mt-8 lg:mt-0">
                        <div class="w-auto sm:w-[450px] h-auto sm:h-[600px] mx-auto">
                            <x-blog-media :file="$blog->file" />
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
