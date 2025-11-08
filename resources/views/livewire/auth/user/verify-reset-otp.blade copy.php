<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 dark:bg-gray-900 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="text-center">
            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900">
                <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c1.656 0 3-1.344 3-3s-1.344-3-3-3-3 1.344-3 3 1.344 3 3 3zm0 2c-2.673 0-8 1.337-8 4v2h16v-2c0-2.663-5.327-4-8-4z" />
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                Verify OTP to Reset Password
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                We've sent a 6-digit verification code to your registered email address
            </p>
            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                {{ session('reset_email') ?? 'example@email.com' }}
            </p>
        </div>

        <div class="rounded-lg bg-white px-8 py-10 shadow dark:bg-gray-800">
            <form wire:submit="verifyOtp" class="space-y-6">
                @if (session()->has('message'))
                    <div class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                    {{ session('message') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <div>
                    <label class="mb-3 block text-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        Enter OTP Code
                    </label>
                    <x-auth.input-otp wire:model="form.code" name="code" :digits="6" />

                    @error('form.code')
                        <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-indigo-500 dark:hover:bg-indigo-400">
                        <span wire:loading.remove wire:target="verifyOtp">Verify & Continue</span>
                        <span wire:loading wire:target="verifyOtp" class="flex items-center">
                            <svg class="mr-2 h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Verifying...
                        </span>
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Didn’t get the code?
                    </p>
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="mt-2 text-sm font-medium text-indigo-600 hover:text-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed dark:text-indigo-400 dark:hover:text-indigo-300">
                        <span wire:loading.remove wire:target="resendOtp">Resend OTP</span>
                        <span wire:loading wire:target="resendOtp">Sending...</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-200">
                        If you don’t see the email, please check your spam or junk folder.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
