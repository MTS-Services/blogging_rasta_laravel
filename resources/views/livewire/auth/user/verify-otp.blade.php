<div class="container mx-auto">
    <div class="min-h-[80vh] flex items-center justify-center  text-text-white">
        <form wire:submit="verify" class="w-full min-h-[50vh] max-w-lg bg-bg-primary rounded-2xl p-8 shadow-lg space-y-8">

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

            <!-- Header -->
            <div class="text-center">
                <h2 class="text-2xl lg:text-5xl md:text-4xl font-medium p-4 text-text-white">
                    {{ __('Confirm your Gmail') }}</h2>
                <p class="text-text-white lg:text-xl text-base">
                    {{ __(' We have sent a code in an Email message to ex**@gmaol.co To confirm your account, please enter the
                                        code.') }}
                </p>
            </div>

            <!-- code -->
            <div>
                <label class="block text-xl font-medium mb-2 text-text-white">{{ __('Code') }}</label>
                <x-ui.input wire:model="form.code" type="text" placeholder="input code" />

                @error('form.code')
                    <p class="mt-2 text-center text-sm text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="text-right px-2 sm:px-6 mb-2" id="resend-container">
                @if ($resendLimitReached)
                    <span class="text-md text-red-400 font-semibold">
                        {{ __('Don\'t resend again. Maximum limit reached.') }}
                    </span>
                @elseif($resendCooldown && $resendCooldown > 0)
                    <span class="text-md text-gray-400">
                        {{ __('Resend available in') }} <span id="countdown"
                            class="font-semibold text-text-white">{{ $resendCooldown }}</span>s
                    </span>
                @else
                    <span wire:click="resend" wire:loading.attr="disabled"
                        class="text-md text-text-white hover:underline cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resend">{{ __('Resend') }}</span>
                        <span wire:loading wire:target="resend">{{ __('Sending...') }}</span>
                    </span>
                @endif
            </div>

            <!-- Submit button -->
            <div>
                <x-ui.button type="submit" class="w-auto py-2!">
                    {{ __('Verify') }}
                </x-ui.button>
            </div>

            <!-- Divider -->
            <div class="flex items-center justify-center space-x-2">
                <hr class="flex-1 border-zinc-700" />
                <span class="text-zinc-400 text-sm">{{ __('Or sign in with') }}</span>
                <hr class="flex-1 border-zinc-700" />
            </div>

            <!-- Social login -->
            <div class="flex justify-center gap-4">
                <button type="button" class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                    <img src="{{ asset('assets/icons/icons8-google.svg') }}" class="w-6 h-6" alt="Google" />
                </button>
                <button type="button" class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                    <img src="{{ asset('assets/icons/icons8-apple-logo.svg') }}" class="w-6 h-6" alt="Apple" />
                </button>
                <button type="button" class="w-12 h-12 flex items-center justify-center bg-white rounded-md">
                    <img src="{{ asset('assets/icons/icons8-facebook.svg') }}" class="w-6 h-6" alt="Facebook" />
                </button>
            </div>

            <!-- Footer -->


            <div class="text-center text-text-white text-sm">
                {{ __('Don\'t have an account?') }}
                <a href="{{ route('register') }}" class="text-zinc-400 hover:underline">{{__('Sign up')}}</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const STORAGE_KEY = 'otp_resend_countdown_{{ user()->id }}';
        const STORAGE_TIMESTAMP_KEY = 'otp_resend_timestamp_{{ user()->id }}';

        let countdown = @js($resendCooldown);
        let resendLimitReached = @js($resendLimitReached);
        let resendAttempts = @js($resendAttempts);
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
            if (resendLimitReached) {
                resendContainer.innerHTML = `
                    <span class="text-md text-red-400 font-semibold">
                        Don't resend again. Maximum limit reached.
                    </span>
                `;
            } else if (countdown > 0) {
                resendContainer.innerHTML = `
                    <span class="text-md text-gray-400">
                        Resend available in <span id="countdown" class="font-semibold text-text-white">${countdown}</span>s
                    </span>
                `;
                countdownElement = document.getElementById('countdown');
            } else {
                resendContainer.innerHTML = `
                    <span wire:click="resend" wire:loading.attr="disabled"
                        class="text-md text-text-white hover:underline cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="resend">Don't have resend again?</span>
                        <span wire:loading wire:target="resend">Sending...</span>
                    </span>
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
                startCountdown(30); // 2 minutes countdown
            } else {
                updateUI();
            }
        });

        // Listen for clear-auth-code event
        Livewire.on('clear-auth-code', () => {
            if (intervalId) {
                clearInterval(intervalId);
            }
            localStorage.removeItem(STORAGE_KEY);
            localStorage.removeItem(STORAGE_TIMESTAMP_KEY);
        });

        // Clean up on page unload
        window.addEventListener('beforeunload', () => {
            if (intervalId) {
                clearInterval(intervalId);
            }
        });
    });
</script>
