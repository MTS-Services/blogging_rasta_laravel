<x-admin::app>
    <x-slot name="pageSlug">{{__('product')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.pm.product.create')
            <x-slot name="title">{{__('Product Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Product / Create')}}</x-slot>
            <livewire:backend.admin.product-management.product.create />
        @break

        @case('admin.pm.product.edit')
            <x-slot name="title">{{__('Product  Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Product / Edit')}}</x-slot>
            <livewire:backend.admin.product-management.product.edit :data="$data"/>
        @break

        @case('admin.pm.product.trash')
            <x-slot name="title">{{__('Product Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Product / Trash')}}</x-slot>
            <livewire:backend.admin.product-management.product.trash />
        @break

        @case('admin.pm.product.view')
            <x-slot name="title">{{__('Product View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Product / View')}}</x-slot>
            <livewire:backend.admin.product-management.product.show :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Product List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Product / List')}}</x-slot>
            <livewire:backend.admin.product-management.product.index />

    @endswitch

</x-admin::app>