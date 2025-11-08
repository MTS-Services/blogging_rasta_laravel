<div class="flex flex-col gap-6 container mx-auto min-h-[80vh]  max-w-lg">
    <x-auth-header 
        :title="__('Reset password')" 
        :description="__('Please enter your new password below')" 
    />
    
    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address (read-only for clarity) -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            readonly
            disabled
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('New Password')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Enter new password') }}"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Re-enter new password') }}"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Reset password') }}
            </flux:button>
        </div>
    </form>
</div>
