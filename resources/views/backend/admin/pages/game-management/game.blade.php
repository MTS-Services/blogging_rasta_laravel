<x-admin::app>
    <x-slot name="pageSlug">{{__('game')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.gm.game.create')
            <x-slot name="title">{{__('Game Create')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Create')}}</x-slot>
            <livewire:backend.admin.game-management.game.create />
        @break
         @case('admin.gm.game.view')
            <x-slot name="title">{{__('Game View')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game View')}}</x-slot>
            <livewire:backend.admin.game-management.game.show :game="$game" />
        @break
         @case('admin.gm.game.edit')
            <x-slot name="title">{{__('Game Edit')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Game Management / Game Edit')}}</x-slot>
            <livewire:backend.admin.game-management.game.edit :game="$game" />
        @break

         @case('admin.gm.game.trash')
                 <x-slot name="title">{{__('Game Trash List')}}</x-slot>
             <x-slot name="breadcrumb">{{__('Game Management / Game Trash List')}}</x-slot>
            <livewire:backend.admin.game-management.game.trash />
        @break

        @default
            <x-slot name="title">{{__('Game List')}}</x-slot>
             <x-slot name="breadcrumb">{{__('Game Management / Game List')}}</x-slot>
            <livewire:backend.admin.game-management.game.index />
    @endswitch

</x-admin::app>
