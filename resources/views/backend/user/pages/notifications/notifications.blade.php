<x-user::app>
    <x-slot name="title">Notifications</x-slot>
    <x-slot name="pageSlug">{{ __('notifications') }}</x-slot>
    {{-- <x-tiny-m-c-e-config /> --}}
    <livewire:backend.user.notifications.notifications/>
    {{-- <livewire:livewire-example /> --}}
</x-user::app>
