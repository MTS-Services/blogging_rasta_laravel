<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-6">
        <div class="container mx-auto min-h-[80vh] flex items-center justify-center">
            <script>
                function togglePassword(id) {
                    const input = document.getElementById(id);
                    input.type = input.type === "password" ? "text" : "password";
                }
            </script>

            <div class="flex items-center justify-center  text-text-white px-4 sm:px-6 lg:px-8">
                <form method="POST" wire:submit.prevent="resetPassword" class="w-full max-w-md sm:max-w-lg md:max-w-xl">
                    <div class="bg-bg-primary rounded-2xl p-6 sm:p-8 shadow-lg flex flex-col justify-between min-h-[60vh] ">

                        <!-- Header -->
                        <div class="mb-6 text-center">
                            <h2 class="text-3xl sm:text-4xl font-medium text-text-white">{{__('Create Password')}}</h2>
                            <p class="text-text-white lg:text-xl sm:text-lg mt-2">
                                {{ __('Hi! Welcome back, you’ve been missed') }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="mb-4 sm:mb-6 px-2 sm:px-6">
                            <label class="block text-lg sm:text-2xl font-medium mb-2 text-text-white">{{__('Email')}}</label>
                            <x-ui.input type="email" placeholder="example@gmail.com" disabled wire:model="email"
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
                                    <svg class="w-5 h-5" fill="none" stroke="zinc" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror

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

                        @error('confirmPassword')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror

                        <!-- Submit button -->
                        <div class="flex justify-center mb-6 px-2 sm:px-6">
                            <button type="submit"
                                class="bg-zinc-600 hover:bg-zinc-700 transition-colors text-text-white font-medium py-3 w-full sm:w-auto sm:px-24 md:px-48 rounded-full">
                                {{__('Sign in')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
