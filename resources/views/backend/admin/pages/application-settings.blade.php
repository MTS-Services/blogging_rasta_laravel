<x-admin::app>


    @switch(Route::currentRouteName())
        @case('admin.as.tik-tok-settings')
            <x-slot name="title">{{ __('TikTok Settings') }}</x-slot>
              <x-slot name="pageSlug">{{ __('tik_tok_settings') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Application Settings / TikTok Settings') }} </x-slot>
            <livewire:backend.admin.application-settings.tiktok-settings />
        @break
        @case('admin.as.database-settings')
            <x-slot name="title">{{ __('Database Settings') }}</x-slot>
              <x-slot name="pageSlug">{{ __('database_settings') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Application Settings / Database Settings') }} </x-slot>
            <livewire:backend.admin.application-settings.database-settings />
        @break

        @default
            <x-slot name="pageSlug">{{ __('general_settings') }}</x-slot>
            <x-slot name="title">{{ __('General Settings') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Application Settings / General Settings') }}</x-slot>
            <livewire:backend.admin.application-settings.general-settings />
    @endswitch

</x-admin::app>
