<x-admin::app>
    <x-slot name="pageSlug">{{__('currency')}}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.as.currency.create')
            <x-slot name="breadcrumb">{{__('Application Settings > Currency Create')}}</x-slot>
            <x-slot name="title">{{__('Currency Create')}}</x-slot>
            <livewire:backend.admin.settings.currency.create />
        @break

        @case('admin.as.currency.edit')
            <x-slot name="breadcrumb">{{__('Application Settings > Currency Edit')}}</x-slot>
            <x-slot name="title">{{__('Currency Edit')}}</x-slot>
            {{-- @dd($data, 'currency') --}}
            <livewire:backend.admin.settings.currency.edit :data="$data" />
        @break

        @case('admin.as.currency.trash')
            <x-slot name="breadcrumb">{{__('Application Settings > Currency Trash')}}</x-slot>
            <x-slot name="title">{{__('Currency Trash')}}</x-slot>
            <livewire:backend.admin.settings.currency.trash />
        @break

        @case('admin.as.currency.show')
            <x-slot name="breadcrumb">{{__('Application Settings > Currency Details')}}</x-slot>
            <x-slot name="title">{{__('Currency Details')}}</x-slot>
            <livewire:backend.admin.settings.currency.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{{__('Application Settings > Currency List')}}</x-slot>
            <x-slot name="title">{{__('Currency List')}}</x-slot>
            <livewire:backend.admin.settings.currency.index />
    @endswitch

</x-admin::app>
