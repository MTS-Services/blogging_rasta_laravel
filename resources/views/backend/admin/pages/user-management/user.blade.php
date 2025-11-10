<x-admin::app>
    <x-slot name="pageSlug">{{ __('admin-users') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.um.user.create')
            <x-slot name="title">{{ __('User Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / Create') }}</x-slot>
            <livewire:backend.admin.user-management.user.create />
        @break

        @case('admin.um.user.edit')
            <x-slot name="title">{{ __('User Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / Edit') }}</x-slot>
            <livewire:backend.admin.user-management.user.edit :model="$data" />
        @break

        @case('admin.um.user.trash')
            <x-slot name="title">{{ __('Users Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / Trash') }}</x-slot>
            <livewire:backend.admin.user-management.user.trash />
        @break

        @case('admin.um.user.view')
            <x-slot name="title">{{ __('User View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / View') }}</x-slot>
            <livewire:backend.admin.user-management.user.view :model="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Users List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Management / List') }}</x-slot>
            <livewire:backend.admin.user-management.user.index />
    @endswitch

</x-admin::app>
