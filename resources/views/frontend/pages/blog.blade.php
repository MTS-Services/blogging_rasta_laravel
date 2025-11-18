<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('blog.details')
            <x-slot name="title">{{ __('Blog Details') }}</x-slot>
            <x-slot name="pageSlug">{{ __('blog_details') }}</x-slot>
            <livewire:frontend.blog-details :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Blog') }}</x-slot>
            <x-slot name="pageSlug">{{ __('blog') }}</x-slot>
            <livewire:frontend.blog />
    @endswitch
</x-frontend::app>
