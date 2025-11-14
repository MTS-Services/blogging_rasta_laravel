<x-frontend::app>
    <x-slot name="title">{{ __('Product') }}</x-slot>
    <x-slot name="pageSlug">{{ __('products') }}</x-slot>
    <livewire:frontend.product />
</x-frontend::app>