<x-admin::app>
    <x-slot name="pageSlug">{{__('product-type')}}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.pm.productType.create')
            <x-slot name="breadcrumb">{{__('Product Management > Product Type Create')}}</x-slot>
            <x-slot name="title">{{__('Product Type Create')}}</x-slot>
            <livewire:backend.admin.product-management.product-type.create />
        @break

        @case('admin.pm.productType.edit')
            <x-slot name="breadcrumb">{{__('Product Management > Product Type Edit')}}</x-slot>
            <x-slot name="title">{{__('Product Type Edit')}}</x-slot>
            <livewire:backend.admin.product-management.product-type.edit :data="$data" />
        @break

        @case('admin.pm.productType.trash')
            <x-slot name="breadcrumb">{{__('Product Management > Product Type Trash')}}</x-slot>
            <x-slot name="title">{{__('Product Type Trash')}}</x-slot>
            <livewire:backend.admin.product-management.product-type.trash />
        @break

        @case('admin.pm.productType.show')
            <x-slot name="breadcrumb">{{__('Product Management > Product Type Details')}}</x-slot>
            <x-slot name="title">{{__('Currency Details')}}</x-slot>
            <livewire:backend.admin.product-management.product-type.show :data="$data" />
        @break

        @default
            <x-slot name="breadcrumb">{{__('Product Management > Product Type List')}}</x-slot>
            <x-slot name="title">{{__('Product Type List')}}</x-slot>
            <livewire:backend.admin.product-management.product-type.index />
    @endswitch

</x-admin::app>
