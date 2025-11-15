<x-frontend::app>
    <x-slot name="title">{{ __('Blog') }}</x-slot>
    <x-slot name="pageSlug">{{ __('blog') }}</x-slot>
    <livewire:frontend.blog />
</x-frontend::app>