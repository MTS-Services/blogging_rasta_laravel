<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('user-video-feed')
            <x-slot name="title">{{ __('User Video Feed ') }}</x-slot>
            <x-slot name="pageSlug">{{ __('user-video-feed ') }}</x-slot>
            <livewire:frontend.user-video-feed :username="$username" />
        @break

        @default
            <x-slot name="title">{{ __('Flux Vidéos & Tendances TikTok | DiodioGlow TV') }}</x-slot>
            <x-slot name="pageSlug">{{ __('video-feed') }}</x-slot>
            <livewire:frontend.video-feed />
    @endswitch
</x-frontend::app>
