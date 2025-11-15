<x-admin::app>


    @switch(Route::currentRouteName())
        @case('admin.asm.application-settings.view')
            <x-slot name="title">{{ __('') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('') }} </x-slot>
            <livewire:backend.admin.audit-log-management.view />
        @break

        @default
            <x-slot name="pageSlug">{{ __('general_settings') }}</x-slot>
            <x-slot name="title">{{ __('general_settings') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Application Settings / General Settings') }}</x-slot>
            <livewire:backend.admin.application-settings.general-settings />
    @endswitch

</x-admin::app>
