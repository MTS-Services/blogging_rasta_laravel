{{-- <x-admin::app>
 <x-slot name="title">{{ __('Tiktok Video') }}</x-slot>
    <x-slot name="pageSlug">{{ __('tiktok-video') }}</x-slot>
     <x-slot name="breadcrumb">{{ __('Tiktok Video') }} </x-slot>
    <livewire:backend.admin.tik-tok-management.tik-tok-videos />
</x-admin::app> --}}

<x-admin::app>
    <x-slot name="pageSlug">{{__('tiktok-video')}}</x-slot>

    @switch(Route::currentRouteName())
        @case('admin.video-keyword')
            <x-slot name="title">{{__('Tiktok Keywords')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Tiktok Video / Keywords')}}</x-slot>
            <livewire:backend.admin.tik-tok-management.video-keywords :data="$data"/>
        @break

        @default
            <x-slot name="title">{{__('Tiktok Video')}}</x-slot>
            <x-slot name="breadcrumb">{{__('Tiktok Video')}}</x-slot>
            <livewire:backend.admin.tik-tok-management.tik-tok-videos />
    @endswitch

</x-admin::app>