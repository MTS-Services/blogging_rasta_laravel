<x-admin::app>
    <x-slot name="pageSlug">{{__('blog')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.um.admin.create')
            <x-slot name="title">{{__('Blogs Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Blog Management / Create')}}</x-slot>
            <livewire:backend.admin.blog.create />
        @break

        @case('admin.um.admin.edit')
            <x-slot name="title">{{__('Blogs Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Blog Management / Edit')}}</x-slot>
            <livewire:backend.admin.blog.edit :data="$data"/>
        @break

        @case('admin.um.admin.trash')
            <x-slot name="title">{{__('Blogs Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Blog Management / Trash')}}</x-slot>
            <livewire:backend.admin.blog.trash />
        @break

        @case('admin.um.admin.view')
            <x-slot name="title">{{__('Blogs View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Blog Management / View')}}</x-slot>
            <livewire:backend.admin.blog.view :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Blogs List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Blog Management / List')}}</x-slot>
            <livewire:backend.admin.blog.index />
    @endswitch

</x-admin::app>