<div>
    <section class="bg-bg-primary min-h-[80vh]">
        <div class="container-wide py-10 px-4 sm:px-6 lg:px-8">
            {{-- Back button --}}
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}" wire:navigate
                class="inline-flex items-center gap-2 text-text-muted font-inter text-sm font-medium hover:text-second-500 transition-colors mb-6">
                <flux:icon name="arrow-left" class="w-4 h-4 shrink-0" />
                {{ __('Back') }}
            </a>
            {{-- Page title --}}
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold font-montserrat text-text-primary">
                    {{ __('My Account') }}
                </h1>
                <p class="mt-2 text-text-muted font-inter">
                    {{ __('Manage your profile and preferences') }}
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                {{-- Profile card --}}
                <div class="rounded-2xl overflow-hidden shadow-xl border border-zinc-200 dark:border-zinc-700 bg-bg-primary">
                    {{-- Cover / accent bar --}}
                    <div class="h-24 sm:h-32 bg-gradient-to-r from-second-500 to-second-600"></div>

                    <div class="relative px-6 sm:px-8 pb-8 -mt-12 sm:-mt-16">
                        {{-- Avatar --}}
                        <div class="flex flex-col sm:flex-row sm:items-end sm:gap-6">
                            <div class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 rounded-2xl border-4 border-bg-primary shadow-lg overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-second-500/20 text-second-500 text-3xl font-bold font-playfair">
                                        {{ $user->initials() }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 sm:mt-0 sm:pb-1">
                                <h2 class="text-2xl font-bold font-montserrat text-text-primary">
                                    {{ $user->name }}
                                </h2>
                                @if($user->username)
                                    <p class="text-text-muted font-inter">{{ "@".$user->username }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Info grid --}}
                        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="flex items-start gap-4 p-4 rounded-xl bg-second-500/10 border border-second-500/20">
                                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-second-500/20 flex items-center justify-center">
                                    <flux:icon name="envelope" class="w-5 h-5 text-second-500" />
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-text-muted uppercase tracking-wider font-inter">{{ __('Email') }}</p>
                                    <p class="mt-1 text-text-primary font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                            @if($user->email_verified_at)
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-second-500/10 border border-second-500/20">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-second-500/20 flex items-center justify-center">
                                        <flux:icon name="check-badge" class="w-5 h-5 text-second-500" />
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-text-muted uppercase tracking-wider font-inter">{{ __('Verified') }}</p>
                                        <p class="mt-1 text-text-primary font-medium">{{ __('Email verified') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($user->last_login_at)
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-bg-primary border border-zinc-200 dark:border-zinc-700">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-bg-primary border border-zinc-200 dark:border-zinc-700 flex items-center justify-center">
                                        <flux:icon name="clock" class="w-5 h-5 text-text-muted" />
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-text-muted uppercase tracking-wider font-inter">{{ __('Last login') }}</p>
                                        <p class="mt-1 text-text-primary font-medium">{{ $user->last_login_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="mt-8 flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg font-inter text-sm font-medium bg-bg-primary border border-zinc-300 dark:border-zinc-600 text-text-primary hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                                    <flux:icon name="arrow-right-start-on-rectangle" class="w-4 h-4" />
                                    {{ __('Log out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
