<x-admin::app>
    <x-slot name="pageSlug">{{ __('user-category') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.tm.user-category.create')
            <x-slot name="title">{{ __('User Category Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Category / Create') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user-category.create />
        @break

        @case('admin.tm.user-category.edit')
            <x-slot name="title">{{ __('User Category  Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Category / Edit') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user-category.edit :data="$data" />
        @break

        @case('admin.tm.user-category.trash')
            <x-slot name="title">{{ __('User Category Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Category / Trash') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user-category.trash />
        @break

        @case('admin.tm.user-category.view')
            <x-slot name="title">{{ __('User Category View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Category / View') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user-category.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('User Category List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('User Category / List') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user-category.index />
    @endswitch

</x-admin::app>
