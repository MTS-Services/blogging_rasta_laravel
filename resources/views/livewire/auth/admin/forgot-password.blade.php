<div class="container mx-auto">
    <div class="min-h-[75vh] flex items-center justify-center text-text-white">

        <!-- Correct form submission -->
        <form wire:submit="sendPasswordResetOtp"
            class=" w-full min-h-[55vh] max-w-lg bg-bg-primary rounded-2xl p-8 shadow-lg space-y-8">

            <!-- Header -->
            <div class="text-center">
                <h2 class="text-4xl font-medium p-4 text-text-white">{{__('Forget Your Password?')}}</h2>
                <p class="text-text-white lg:text-xl text-sm">
                    {{ __('Enter your email address, we will send a message with a code to reset your password.') }}
                </p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xl font-medium mb-2 text-text-white">{{__('Email')}}</label>
                <x-ui.input type="email" placeholder="example@gmail.com" wire:model="email" />
            </div>

            <!-- Error message -->
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror

            <!-- Submit button -->
            <div>
                <x-ui.button type="submit" class="w-auto py-2!">
                    {{ __('Reset Password') }}
                </x-ui.button>
            </div>


            <x-ui.button type="submit" href="{{ route('admin.login') }}"  variant="secondary" class="w-auto py-2!">
                {{ __('Back') }}
            </x-ui.button>
        </form>
    </div>
</div>
