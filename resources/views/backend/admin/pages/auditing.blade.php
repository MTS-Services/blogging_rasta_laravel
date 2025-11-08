<x-admin::app>
    <x-slot name="pageSlug">{{__('auditing')}}</x-slot>

    @switch(Route::currentRouteName())

        @case('admin.alm.audit.view')
            <x-slot name="title">{{__('Auditing Log Details')}}</x-slot>
            <x-slot name="breadcrumb">{{ __('Auditing Log > Details') }} </x-slot>
            <livewire:backend.admin.audit-log-management.view :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Auditing Log List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Auditing Log > List')}}</x-slot>
            <livewire:backend.admin.audit-log-management.index />
    @endswitch

</x-admin::app>
