<div class="container min-h-[80vh] py-8">
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>

    <div class="min-h-[80vh] flex items-center justify-center text-text-white px-4  sm:px-6 lg:px-8 ">
        <form method="POST" wire:submit.prevent="login" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
            <div class="bg-bg-primary rounded-2xl p-6 sm:p-8 shadow-lg flex flex-col justify-between min-h-[75vh]">

                <!-- Header -->
                <div class="mb-6 text-center">
                    <h2 class="text-3xl sm:text-4xl font-medium text-text-white">{{ __('Sign in') }}</h2>
                    <p class="text-text-white lg:text-xl sm:text-lg mt-2">
                        {{ __('Hi! Welcome back, you’ve been missed') }}
                    </p>
                </div>

                <!-- Email -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Email') }}</label>
                    <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email" />
                    {{-- Error message --}}
                    <x-ui.input-error :messages="$errors->get('email')" />
                </div>

                <!-- Error message -->
                @error('message')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror

                <!-- Password -->
                <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                    <x-ui.label
                        class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{ __('Password') }}</x-ui.label>
                    <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password" />
                    <x-ui.input-error :messages="$errors->get('password')" />
                </div>

                <!-- Error message -->

                <!-- Forgot password -->
                {{-- <div class="text-right px-2 sm:px-6 mb-6">
                    <a href="#" class="text-md text-[#853fee] hover:underline">Forgot password?</a>
                </div> --}}

                @if (Route::has('password.request'))
                    <div class=" text-right px-2 sm:px-6 mb-2">
                        <a href="{{ route('password.request') }}" wire:navigate
                            class="text-md text-accent hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                @endif

                <!-- Sign in button -->
                <div class=" flex justify-center px-2 sm:px-6">
                    <x-ui.button type="submit" class="w-auto py-2!">
                        {{ __('Sign in') }}
                    </x-ui.button>
                </div>

                <!-- Divider -->
                <div class="flex items-center mb-2 px-4">
                    <hr class="flex-1 border-zinc-700" />
                    <span class="px-3 text-sm sm:text-md text-zinc-500">{{ __('Or sign in with') }}</span>
                    <hr class="flex-1 border-zinc-700" />
                </div>

                <div>
                    <!-- Social login -->
                    <div class="flex justify-center gap-4 mb-2">
                        <a href="{{ route('google.redirect') }}"
                            class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                                alt="Google" />
                        </a>
                        <a href="{{ route('apple.login') }}"
                            class="w-10 h-10 sm:w-12 sm:h-12 flex z-30 items-center justify-center bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}"
                                class="w-8 sm:w-10 h-8 sm:h-10" alt="Apple" />
                        </a>

                        <a href="{{ route('auth.facebook') }}"
                            class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                            <img src="{{ asset('assets/icons/icons8-facebook.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                                alt="Facebook" />
                        </a>
                    </div>

                    <!-- Sign up link -->
                    <div class="text-center text-sm text-text-white">
                       {{ __(' Don’t have an account?') }}
                        <a href="{{ route('register') }}"
                            class="text-purple-400 hover:underline">{{ __('Sign up') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
