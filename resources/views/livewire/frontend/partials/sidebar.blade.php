<aside>
    <flux:sidebar stashable sticky
        class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">

        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <flux:brand href="{{ route('home') }}" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
            class="px-2 dark:hidden" />
        <flux:brand href="{{ route('home') }}" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="px-2 hidden dark:flex" />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('home') }}" wire:navigate
                :current="request()->routeIs('home')">
                {{ __('Home') }}
            </flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun" />
            <flux:radio value="dark" icon="moon" />
            <flux:radio value="system" icon="computer-desktop" />
        </flux:radio.group>

        @auth
            <flux:navlist variant="outline">
                <flux:navlist.item icon="user-circle" href="#">{{__('Profile')}}</flux:navlist.item>
                <flux:navlist.item icon="envelope" href="#">{{__('Messages')}}</flux:navlist.item>
                <flux:navlist.item icon="wrench-screwdriver" href="#">{{__('Settings')}}</flux:navlist.item>
                <flux:navlist.item icon="credit-card" href="#">{{__('Billing')}}</flux:navlist.item>
                <flux:navlist.item icon="arrow-right-start-on-rectangle" href="#">{{__('Logout')}}</flux:navlist.item>
            </flux:navlist>
        @else
            <flux:navlist variant="outline">
                <flux:navlist.item icon="log-in" href="{{ route('login') }}" wire:navigate>{{__('Login')}}</flux:navlist.item>
                <flux:navlist.item icon="user-plus" href="{{ route('register') }}" wire:navigate>{{ __('Register') }}
                </flux:navlist.item>
            </flux:navlist>
        @endauth
    </flux:sidebar>
</aside>
