<x-frontend::app>
    <x-slot name="title">{{ __('My Account') }} - {{ site_name() }}</x-slot>
    <x-slot name="pageSlug">{{ __('My Account') }}</x-slot>
    <livewire:frontend.user-profile />
</x-frontend::app>
