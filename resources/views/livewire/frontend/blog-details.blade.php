<div>
    {{-- Open Graph / meta tags are output in the layout head via the blog page's meta slot for crawlers (Facebook, WhatsApp, etc.) --}}
    <section class="bg-bg-primary">
        <div class="container pb-10">
            @if(!empty($data->file))
            <div class="w-full pt-8 lg:pt-0 pb-5">
                <div class="w-full h-auto mx-auto">
                    <x-blog-media :file="$data->file" :alt="$data->title" />
                </div>
            </div>
            @endif
            @if($data->category)
                <a href="{{ route('blog', ['category' => $data->category->slug]) }}" wire:navigate class="inline-block text-sm text-bg-primary font-medium mb-2">{{ $data->category->title }}</a>
            @endif
            <h1 class="text-3xl font-semibold font-montserrat text-text-primary">
                {{ __($data->title) }}</h1>
            <p class="text-base pt-4  text-text-primary">
                {!! $data->description !!}
            </p>

            <livewire:frontend.blog-post-comments :blog="$data" />
        </div>
    </section>
</div>
