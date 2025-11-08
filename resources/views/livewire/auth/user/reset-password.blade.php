<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-6">
        <div class="container mx-auto min-h-[80vh] py-10 sm:py-15">
            <script>
                function togglePassword(id) {
                    const input = document.getElementById(id);
                    input.type = input.type === "password" ? "text" : "password";
                }
            </script>

            <div class="flex items-center justify-center px-4 sm:px-6 lg:px-8">
                <form method="POST" wire:submit.prevent="resetPassword" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
                    <div class="bg-bg-primary rounded-2xl p-6 sm:p-8 shadow-lg flex flex-col justify-between min-h-[60vh]">

                        <!-- Header -->
                        <div class="mb-6 text-center">
                            <h2 class="text-3xl sm:text-4xl font-medium text-text-white">{{ __('Create Password') }}</h2>
                            <p class="text-text-whitelg:text-xl sm:text-lg mt-2">
                                {{ __('Hi! Welcome back, you’ve been missed') }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{__('Email')}}</label>
                            <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email"
                            />
                        </div>

                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror

                        <!-- Password -->
                        <div class="mb-2 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{__('Password')}}</label>

                            <div class="relative">
                                <x-ui.input type="password" id="password" placeholder="Aex@8465" wire:model="password"
                                />
                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-zinc-400 hover:text-zinc-300">
                                    <svg class="w-5 h-5" fill="none" stroke="gray" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            {{-- Error message --}}
                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Confirm Password -->
                        <div class="mb-2 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{__('Confirm
                                Password')}}</label>

                            <div class="relative">
                                <x-ui.input type="password" id="confirmPassword" placeholder="Aex@8465"
                                    wire:model="password_confirmation"/>
                                <button type="button" onclick="togglePassword('confirmPassword')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-zinc-400 hover:text-zinc-300">
                                    <svg class="w-5 h-5" fill="none" stroke="gray" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="flex justify-center mb-6 px-2 sm:px-6">
                            <x-ui.button  type="submit"
                                class="w-auto py-2!">
                               {{ __(' Sign in') }}
                            </x-ui.button>
                        </div>

                        <!-- Divider -->
                        <div class="flex items-center mb-6 px-4">
                            <hr class="flex-1 border-gray-700" />
                            <span class="px-3 text-sm sm:text-md text-zinc-400">{{__('Or sign in with')}}</span>
                            <hr class="flex-1 border-gray-700" />
                        </div>

                        <!-- Social login -->
                        <div class="flex justify-center gap-4 mb-6">
                            <button
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                                <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-8 sm:w-10 h-8 sm:h-10"
                                    alt="Google" />
                            </button>

                            <button
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                                <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}"
                                    class="w-8 sm:w-10 h-8 sm:h-10" alt="Apple" />
                            </button>

                            <button
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-white rounded-md">
                                <img src="{{ asset('assets/icons/icons8-facebook.svg') }}"
                                    class="w-8 sm:w-10 h-8 sm:h-10" alt="Facebook" />
                            </button>
                        </div>

                        <!-- Sign up link -->
                        <div class="text-center text-sm text-text-white">
                            {{ __('Don’t have an account?') }}
                            <a href="{{ route('register') }}" class="text-purple-400 hover:underline" wire:navigate>{{__('Sign up')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
