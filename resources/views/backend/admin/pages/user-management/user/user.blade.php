<x-admin::app>
    <x-slot name="pageSlug">{{__('admin-users')}}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.um.user.create')
            <x-slot name="title">{{__('User Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.create />
        @break

        @case('admin.um.user.edit')
            <x-slot name="title">{{__('User Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.edit :user="$user" />
        @break

        @case('admin.um.user.view')
            <x-slot name="title">{{__('User View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.view :user="$user" />
        @break

        @case('admin.um.user.profileInfo')
            <x-slot name="title">{{__('Profile Info')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.profile.persona-info :user="$user" />
        @break

        @case('admin.um.user.shopInfo')
            <x-slot name="title">{{__('Shop Info')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.profile.shop-info :user="$user" />
        @break

        @case('admin.um.user.kycInfo')
            <x-slot name="title">{{__('KYC Info')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.profile.kyc-info :user="$user" />
        @break

        @case('admin.um.user.statistic')
            <x-slot name="title">{{__('Statistic Info')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.profile.statistic :user="$user" />
        @break

        @case('admin.um.user.referral')
            <x-slot name="title">{{__('Statistic Info')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.profile.referral :user="$user" />
        @break

        @case('admin.um.user.trash')
            <x-slot name="title">{{__('User Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('User Management')}}</x-slot>
            <livewire:backend.admin.user-management.user.trash />
        @break

        @default
            <x-slot name="breadcrumb">{{__('User Management / List')}}</x-slot>
            <x-slot name="title">{{__('User List')}}</x-slot>
            <livewire:backend.admin.user-management.user.index />
    @endswitch

</x-admin::app>
