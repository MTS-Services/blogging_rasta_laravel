<x-frontend::app>

    @switch(Route::currentRouteName())
        @case('TermsOfService')
            <x-slot name="title">{{ __('Conditions Générales d\'Utilisation | DiodioGlow CGU') }}</x-slot>
            <x-slot name="pageSlug">{{ __('terms_of_service ') }}</x-slot>
            <livewire:frontend.terms-of-service />
        @break

        @case('affiliate')
            <x-slot name="title">{{ __('Divulgation d\'Affiliation & Transparence | DiodioGlow') }}</x-slot>
            <x-slot name="pageSlug">{{ __('affiliate_disclosure') }}</x-slot>
            <livewire:frontend.affiliate />
        @break

        @case('contact')
            <x-slot name="title">{{ __('Contactez-Nous & Service Client | DiodioGlow') }}</x-slot>
            <x-slot name="pageSlug">{{ __('Contact_Us') }}</x-slot>
            <livewire:frontend.contact />
        @break

        @case('support')
            <x-slot name="title">{{ __('Support Client & Centre d\'Aide | DiodioGlow Assistance') }}</x-slot>
            <x-slot name="pageSlug">{{ __('support') }}</x-slot>
            <livewire:frontend.support />
        @break

        @default
            <x-slot name="title">{{ __('Politique de Confidentialité & Données | DiodioGlow') }}</x-slot>
            <x-slot name="pageSlug">{{ __('privacy_policy') }}</x-slot>
            <livewire:frontend.privacy-policy />
    @endswitch
</x-frontend::app>
