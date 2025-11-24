<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('video.details')
            <x-slot name="title">{{ __('Video Details') }}</x-slot>
            <x-slot name="pageSlug">{{ __('video_details') }}</x-slot>
            <livewire:frontend.video-details :data="$data" />
        @break
    @endswitch
</x-frontend::app>
