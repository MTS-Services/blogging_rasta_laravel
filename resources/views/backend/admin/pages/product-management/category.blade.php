<x-admin::app>
    <x-slot name="pageSlug">{{__('category')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.pm.category.create')
            <x-slot name="title">{{__('Category Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Category / Create')}}</x-slot>
            <livewire:backend.admin.product-management.category.create />
        @break

        @case('admin.pm.category.edit')
            <x-slot name="title">{{__('Category  Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Category / Edit')}}</x-slot>
            <livewire:backend.admin.product-management.category.edit :data="$data"/>
        @break

        @case('admin.pm.category.trash')
            <x-slot name="title">{{__('Category Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Category / Trash')}}</x-slot>
            <livewire:backend.admin.product-management.category.trash />
        @break

        @case('admin.pm.category.view')
            <x-slot name="title">{{__('Category View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Category / View')}}</x-slot>
            <livewire:backend.admin.product-management.category.show :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Category List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Category / List')}}</x-slot>
            <livewire:backend.admin.product-management.category.index />

            {{-- C:\Users\akhta\Documents\GitHub\blogging_rasta_laravel\resources\views\livewire\backend\admin\product-mangement\category\index.blade.php --}}
    @endswitch

</x-admin::app>