<x-frontend::app>
    @switch(Route::currentRouteName())
        @case('f.products')
            <x-slot name="title">{{ __('Product') }}</x-slot>
            <x-slot name="pageSlug">{{ __('product') }}</x-slot>
            <livewire:frontend.product />
        @break

        @default
            <x-slot name="title">{{ __('Home') }}</x-slot>
            <x-slot name="pageSlug">{{ __('home') }}</x-slot>
            <livewire:frontend.home />
    @endswitch
</x-frontend::app>
