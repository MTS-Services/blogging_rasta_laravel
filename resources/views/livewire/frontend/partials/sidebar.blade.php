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
                <flux:navlist.item icon="user" title="{{ __('My Account') }}" href="{{ route('user.account') }}" wire:navigate>
                    {{ __('Profile') }}
                </flux:navlist.item>
            </flux:navlist>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="h-10 w-full flex items-center gap-3 rounded-lg px-3 py-0 text-start text-sm font-medium text-zinc-500 dark:text-white/80 hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/5 dark:hover:bg-white/[7%] border border-transparent my-px">
                    <flux:icon name="arrow-right-start-on-rectangle" class="size-4 shrink-0" />
                    {{ __('Log out') }}
                </button>
            </form>
        @else
            <flux:navlist variant="outline">
                <flux:navlist.item icon="log-in" title="Login" href="{{ route('login') }}" wire:navigate>
                    {{ __('Login') }}</flux:navlist.item>
                <flux:navlist.item icon="user-plus" title="Register" href="{{ route('register') }}" wire:navigate>
                    {{ __('Register') }}
                </flux:navlist.item>
            </flux:navlist>
        @endauth
    </flux:sidebar>
</aside>
