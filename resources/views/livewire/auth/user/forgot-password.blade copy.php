<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('Forgot Password')" 
        :description="__('Enter your email address to receive a 6-digit verification code')" 
    />

    <!-- Session Message -->
    @if (session()->has('message'))
        <div class="rounded-md bg-green-50 p-4 text-center dark:bg-green-900/20">
            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                {{ session('message') }}
            </p>
        </div>
    @endif

    <!-- Validation Error -->
    @error('email')
        <div class="rounded-md bg-red-50 p-3 text-center dark:bg-red-900/20">
            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        </div>
    @enderror

    <form wire:submit="sendPasswordResetOtp" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email Address')"
            type="email"
            required
            autofocus
            placeholder="email@example.com"
        />

        <flux:button 
            variant="primary" 
            type="submit" 
            class="w-full" 
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove wire:target="sendPasswordResetOtp">
                {{ __('Send Verification Code') }}
            </span>
            <span wire:loading wire:target="sendPasswordResetOtp">
                {{ __('Sending...') }}
            </span>
        </flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        <span>{{ __('Or, return to') }}</span>
        <flux:link :href="route('admin.login')" wire:navigate>{{ __('log in') }}</flux:link>
    </div>
</div>
