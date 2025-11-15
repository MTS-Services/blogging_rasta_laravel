<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('TermsOfService')
            <x-slot name="title">{{ __('Terms of Service ') }}</x-slot>
            <x-slot name="pageSlug">{{ __('terms_of_service ') }}</x-slot>
            <livewire:frontend.terms-of-service />
        @break

        @default
            <x-slot name="title">{{ __('Privacy Policy ') }}</x-slot>
            <x-slot name="pageSlug">{{ __('privacy_policy') }}</x-slot>
            <livewire:frontend.privacy-policy />
    @endswitch
</x-frontend::app>
