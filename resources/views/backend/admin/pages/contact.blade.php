<x-admin::app>
    <x-slot name="pageSlug">{{__('contact')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.contact.trash')
            <x-slot name="title">{{__('Contact Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Contact  / Trash')}}</x-slot>
            <livewire:backend.admin.contact.trash />
        @break

        @case('admin.contact.view')
            <x-slot name="title">{{__('Contact View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Contact  / View')}}</x-slot>
            <livewire:backend.admin.contact.view :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Contact List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Contact  / List')}}</x-slot>
            <livewire:backend.admin.contact.index />
    @endswitch

</x-admin::app>