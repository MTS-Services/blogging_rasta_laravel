<x-admin::app>
    <x-slot name="pageSlug">{{__('admin')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.um.admin.create')
            <x-slot name="title">{{__('Admins Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management / Create')}}</x-slot>
            <livewire:backend.admin.user-management.admin.create />
        @break

        @case('admin.um.admin.edit')
            <x-slot name="title">{{__('Admins Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management / Edit')}}</x-slot>
            <livewire:backend.admin.user-management.admin.edit :model="$data"/>
        @break

        @case('admin.um.admin.trash')
            <x-slot name="title">{{__('Admins Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management / Trash')}}</x-slot>
            <livewire:backend.admin.user-management.admin.trash />
        @break

        @case('admin.um.admin.view')
            <x-slot name="title">{{__('Admins View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management / View')}}</x-slot>
            <livewire:backend.admin.user-management.admin.view :model="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Admins List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management / List')}}</x-slot>
            <livewire:backend.admin.user-management.admin.index />
    @endswitch

</x-admin::app>
