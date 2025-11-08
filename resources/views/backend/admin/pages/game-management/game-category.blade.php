<x-admin::app>
    <x-slot name="pageSlug">{{ __('game-category') }}</x-slot>
    @switch(Route::currentRouteName())
        @case('admin.gm.category.create')
            <x-slot name="title">{{ __('Game Category Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Category Add') }}</x-slot>
            <livewire:backend.admin.game-management.category.create />
        @break

        @case('admin.gm.category.edit')
            <x-slot name="title">{{ __('Game Category Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Category Edit') }}</x-slot>
            <livewire:backend.admin.game-management.category.edit :data="$data" />
        @break

        @case('admin.gm.category.view')
            <x-slot name="title">{{ __('Game Category Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Category Edit') }}</x-slot>
            <livewire:backend.admin.game-management.category.show :data="$data" />
        @break

        @case('admin.gm.category.trash')
            <x-slot name="title">{{ __('Game Category Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Category Trash') }}</x-slot>
            <livewire:backend.admin.game-management.category.trash />
        @break

        @default
            <x-slot name="title">{{ __('Category List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('Game Management / Category List') }}</x-slot>
            <livewire:backend.admin.game-management.category.index />
    @endswitch

</x-admin::app>
