<x-admin::app>
    <x-slot name="pageSlug">{{__('keyword')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.keyword.create')
            <x-slot name="title">{{__('Keyword Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Keyword Management / Create')}}</x-slot>
            <livewire:backend.admin.keyword.create />
        @break

        @case('admin.keyword.edit')
            <x-slot name="title">{{__('Keyword Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Keyword Management / Edit')}}</x-slot>
            <livewire:backend.admin.keyword.edit :data="$data"/>
        @break

        @case('admin.keyword.trash')
            <x-slot name="title">{{__('Keyword Trash')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Keyword Management / Trash')}}</x-slot>
            <livewire:backend.admin.keyword.trash />
        @break

        @case('admin.keyword.view')
            <x-slot name="title">{{__('Keyword View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Keyword Management / View')}}</x-slot>
            <livewire:backend.admin.keyword.view :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Keyword List')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Keyword Management / List')}}</x-slot>
            <livewire:backend.admin.keyword.index />
    @endswitch

</x-admin::app>