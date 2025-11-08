<x-admin::app>
    <x-slot name="pageSlug">{{__('admin')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.am.admin.create')
            <x-slot name="title">{{__('Admins Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management')}}</x-slot>
            <livewire:backend.admin.admin-management.admin.create />
        @break

        @case('admin.am.admin.edit')
            <x-slot name="title">{{__('Admins Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management')}}</x-slot>
            <livewire:backend.admin.admin-management.admin.edit :admin="$admin"/>
        @break

        @case('admin.am.admin.trash')
            <x-slot name="title">{{__('Admins Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management')}}</x-slot>
            <livewire:backend.admin.admin-management.admin.trash />
        @break

        @case('admin.am.admin.view')
            <x-slot name="title">{{__('Admins View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management')}}</x-slot>
            <livewire:backend.admin.admin-management.admin.view :admin="$admin"/>
        @break

        @default
            <x-slot name="title">{{__('Admins List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Admin Management')}}</x-slot>
            <livewire:backend.admin.admin-management.admin.index />
    @endswitch

</x-admin::app>
