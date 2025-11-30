<x-admin::app>
    <x-slot name="pageSlug">{{ __('tiktok-user') }}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.tm.user.create')
            <x-slot name="title">{{ __('TikTok User Create') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('TikTok User / Create') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user.create />
        @break

        @case('admin.tm.user.edit')
            <x-slot name="title">{{ __('TikTok User  Edit') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('TikTok User / Edit') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user.edit :data="$data" />
        @break

        @case('admin.tm.user.trash')
            <x-slot name="title">{{ __('TikTok User Trash') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('TikTok User / Trash') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user.trash />
        @break

        @case('admin.tm.user.view')
            <x-slot name="title">{{ __('TikTok User View') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('TikTok User / View') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user.show :data="$data" />
        @break

        @default
            <x-slot name="title">{{ __('TikTok User List') }}</x-slot>
            <x-slot name="breadcrumb">{{ __('TikTok User / List') }}</x-slot>
            <livewire:backend.admin.tik-tok-management.user.index />
    @endswitch

</x-admin::app>
