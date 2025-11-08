<div class="container mx-auto">
    <div class="min-h-[80vh] flex items-center justify-center  text-text-white">

        <!-- Correct form submission -->
        <form wire:submit="verifyOtp"
            class=" w-full min-h-[55vh] max-w-lg bg-bg-primary rounded-2xl p-8 shadow-lg space-y-8">

            <!-- Header -->
            <div class="text-center">
                <h2 class="text-4xl font-medium p-4 text-text-white">{{ __('Confirm your account') }}</h2>
                <p class="text-text-whitelg:text-xl text-sm">
                    {{ __('We have sent a code in an Email message to ex***@gmail.com To confirm your account, please enter the
                                        code.') }}
                </p>
            </div>

            <!-- Code -->
            <div>
                <label class="block text-xl font-medium mb-2 text-text-white">{{ __('Code') }}</label>
                <x-ui.input type="text" placeholder="Enter your code" wire:model="form.code" />
            </div>

            @error('form.code')
                <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                </p>
            @enderror

            <div class="text-right" id="resend-container">
                @if (isset($resendLimitReached) && $resendLimitReached)
                    <span class="text-md text-red-400 font-semibold">
                        {{ __('Don\'t resend again. Maximum limit reached.') }}
                    </span>
                @elseif($resendCooldown && $resendCooldown > 0)
                    <span class="text-md text-zinc-400">
                        {{ __('Resend available in') }} <span id="countdown"
                            class="font-semibold text-text-white">{{ $resendCooldown }}</span>s
                        <span class="text-xs text-zinc-500">({{ 6 - ($resendAttempts ?? 0) }} left)</span>
                    </span>
                @else
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-md text-zinc-300 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resendOtp">{{ __('Resend') }} <span
                                class="text-xs text-zinc-500">({{ 6 - ($resendAttempts ?? 0) }} left)</span></span>
                        <span wire:loading wire:target="resendOtp">{{__('Sending...')}}</span>
                    </button>
                @endif
            </div>

            <!-- Submit button -->
            <div>
                <x-ui.button class="w-auto py-2!" type="submit">
                    {{ __('Verify') }}
                </x-ui.button>
            </div>

            <!-- Back to login page -->
            <div>
                <x-ui.button href="{{ route('login') }}" variant='secondary' class="w-auto py-2!">
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const STORAGE_KEY = 'password_reset_countdown_{{ $email }}';
        const STORAGE_TIMESTAMP_KEY = 'password_reset_timestamp_{{ $email }}';

        let countdown = @js($resendCooldown);
        let resendLimitReached = @js($resendLimitReached ?? false);
        let resendAttempts = @js($resendAttempts ?? 0);
        let countdownElement = document.getElementById('countdown');
        let resendContainer = document.getElementById('resend-container');
        let intervalId = null;

        function startCountdown(initialSeconds) {
            // Clear any existing interval
            if (intervalId) {
                clearInterval(intervalId);
            }

            countdown = initialSeconds;

            // Store initial countdown and timestamp
            localStorage.setItem(STORAGE_KEY, countdown);
            localStorage.setItem(STORAGE_TIMESTAMP_KEY, Date.now());

            // Update UI immediately
            updateUI();

            intervalId = setInterval(() => {
                countdown--;

                // Update localStorage
                localStorage.setItem(STORAGE_KEY, countdown);

                // Update UI
                updateUI();

                if (countdown <= 0) {
                    clearInterval(intervalId);
                    localStorage.removeItem(STORAGE_KEY);
                    localStorage.removeItem(STORAGE_TIMESTAMP_KEY);

                    // Update component state and reload
                    @this.updateResendCooldown().then(() => {
                        location.reload();
                    });
                }
            }, 1000);
        }

        function updateUI() {
            const remainingResends = 6 - resendAttempts;

            if (resendLimitReached) {
                resendContainer.innerHTML = `
                    <span class="text-md text-red-400 font-semibold">
                        Don't resend again. Maximum limit reached.
                    </span>
                `;
            } else if (countdown > 0) {
                resendContainer.innerHTML = `
                    <span class="text-md text-zinc-400">
                        Resend available in <span id="countdown" class="font-semibold text-text-white">${countdown}</span>s
                        <span class="text-xs text-zinc-500">(${remainingResends} left)</span>
                    </span>
                `;
                countdownElement = document.getElementById('countdown');
            } else {
                resendContainer.innerHTML = `
                    <button type="button" wire:click="resendOtp" wire:loading.attr="disabled"
                        class="text-md text-zinc-300 hover:underline disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resendOtp">Resend <span class="text-xs text-zinc-500">(${remainingResends} left)</span></span>
                        <span wire:loading wire:target="resendOtp">Sending...</span>
                    </button>
                `;
            }
        }

        // Check if there's a stored countdown on page load
        const storedTimestamp = localStorage.getItem(STORAGE_TIMESTAMP_KEY);
        if (storedTimestamp && !resendLimitReached) {
            const elapsed = Math.floor((Date.now() - parseInt(storedTimestamp)) / 1000);
            const storedCountdown = parseInt(localStorage.getItem(STORAGE_KEY) || '0');
            const remainingTime = Math.max(0, storedCountdown - elapsed);

            if (remainingTime > 0) {
                startCountdown(remainingTime);
            } else {
                // Clean up expired countdown
                localStorage.removeItem(STORAGE_KEY);
                localStorage.removeItem(STORAGE_TIMESTAMP_KEY);
            }
        } else if (countdown && countdown > 0 && !resendLimitReached) {
            // Start countdown from server value
            startCountdown(countdown);
        }

        // Listen for resend event to restart countdown
        Livewire.on('otp-resent', (event) => {
            // Get attempts from event data
            if (event && event[0] && event[0].attempts) {
                resendAttempts = event[0].attempts;
            } else {
                resendAttempts++;
            }

            resendLimitReached = resendAttempts >= 6;

            console.log('Resend event received', {
                attempts: resendAttempts,
                limitReached: resendLimitReached
            });

            if (!resendLimitReached) {
                startCountdown(30);
            } else {
                updateUI();
            }
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (intervalId) {
                clearInterval(intervalId);
            }
        });
    });
</script>
