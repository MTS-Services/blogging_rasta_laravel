<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('TermsOfService')
            <x-slot name="title">{{ __('Terms of Service ') }}</x-slot>
            <x-slot name="pageSlug">{{ __('terms_of_service ') }}</x-slot>
            <livewire:frontend.terms-of-service />
        @break

        @case('affiliate')
            <x-slot name="title">{{ __('Affiliate Disclosure') }}</x-slot>
            <x-slot name="pageSlug">{{ __('affiliate_disclosure') }}</x-slot>
            <livewire:frontend.affiliate />
        @break
        @case('support')
            <x-slot name="title">{{ __('Support') }}</x-slot>
            <x-slot name="pageSlug">{{ __('support') }}</x-slot>
            <livewire:frontend.support />
        @break

        @default
            <x-slot name="title">{{ __('Privacy Policy ') }}</x-slot>
            <x-slot name="pageSlug">{{ __('privacy_policy') }}</x-slot>
            <livewire:frontend.privacy-policy />
    @endswitch
</x-frontend::app>
