<x-admin::app>
    <x-slot name="pageSlug">{{ __('Blog Category') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.blog-category.create')
            <x-slot name="title">{{ __('Blog Category Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Blog Management / Category / Create') }}</x-slot>
            <livewire:backend.admin.blog-category.create />
        @break

        @case('admin.blog-category.edit')
            <x-slot name="title">{{ __('Blog Category Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Blog Management / Category / Edit') }}</x-slot>
            <livewire:backend.admin.blog-category.edit :data="$data" />
        @break

        @case('admin.blog-category.trash')
            <x-slot name="title">{{ __('Blog Category Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Blog Management / Category / Trash') }}</x-slot>
            <livewire:backend.admin.blog-category.trash />
        @break

        @case('admin.blog-category.view')
            <x-slot name="title">{{ __('Blog Category View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Blog Management / Category / View') }}</x-slot>
            <livewire:backend.admin.blog-category.view :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('Blog Category List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Blog Management / Category / List') }}</x-slot>
            <livewire:backend.admin.blog-category.index />
    @endswitch

</x-admin::app>
