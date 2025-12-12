<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('video.details')
            <x-slot name="title">{{ Str::limit($data->title, 50) }}</x-slot>
            <x-slot name="pageSlug">{{ __('video_details') }}</x-slot>
            <livewire:frontend.video-details :data="$data" />
        @break
    @endswitch
</x-frontend::app>
