<x-admin::app>
    <x-slot name="pageSlug">{{__('language')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.as.language.create')
            <x-slot name="breadcrumb">{{ __('Application Settings > Language Create') }}
            </x-slot>
            <x-slot name="title">{{__('Language Create')}}</x-slot>
            <livewire:backend.admin.settings.language.create />
        @break

        @case('admin.as.language.edit')
            <x-slot name="breadcrumb">{{__('Application Settings > Language Edit')}}</x-slot>
            <x-slot name="title">{{__('Language Edit')}}</x-slot>
            <livewire:backend.admin.settings.language.edit :language="$language"/>
        @break

        @case('admin.as.language.trash')
            <x-slot name="breadcrumb">{{__('Application Settings > Language Trash')}}</x-slot>
            <x-slot name="title">{{__('Language Trash')}}</x-slot>
            <livewire:backend.admin.settings.language.trash />
        @break

        @case('admin.as.language.view')
            <x-slot name="breadcrumb">{{__('Application Settings > Language Details')}}</x-slot>
            <x-slot name="title">{{__('Language Details')}}</x-slot>
            <livewire:backend.admin.settings.language.view :language="$language"/>
        @break

        @default
            <x-slot name="breadcrumb">{{__('Application Settings > Language List')}}</x-slot>
            <x-slot name="title">{{__('Language List')}}</x-slot>
            <livewire:backend.admin.settings.language.index />
    @endswitch

</x-admin::app>
