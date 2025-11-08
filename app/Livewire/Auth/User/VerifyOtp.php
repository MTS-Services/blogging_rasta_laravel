<?php

namespace App\Livewire\Auth\User;

use App\Enums\OtpType;
use App\Livewire\Forms\Auth\Otp\OtpForm;
use App\Notifications\UserOtpNotification;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class VerifyOtp extends Component
{
    use WithNotification;

    public OtpForm $form;
    public ?int $resendCooldown = null;
    public int $resendAttempts = 0;
    public bool $resendLimitReached = false;

    public function mount()
    {
        // Redirect if not authenticated
        if (!user()) {
            return redirect()->route('login');
        }

        // Redirect if already verified
        if (is_email_verified(user())) {
            return redirect()->route('user.purchased-orders');
        }

        // Load resend attempts from cache
        $this->loadResendAttempts();

        // Check if there's an active cooldown
        $this->updateResendCooldown();

        // Generate and send OTP when component loads (only if no cooldown)
        if ($this->resendCooldown === null && !$this->resendLimitReached) {
            $this->sendOtp();
        }
    }

    protected function loadResendAttempts()
    {
        $cacheKey = 'otp_resend_attempts:' . user()->id;
        $this->resendAttempts = cache()->get($cacheKey, 0);
        $this->resendLimitReached = $this->resendAttempts >= 6;
    }

    protected function incrementResendAttempts()
    {
        $this->resendAttempts++;
        $cacheKey = 'otp_resend_attempts:' . user()->id;
        // Store attempts for 1 hour
        cache()->put($cacheKey, $this->resendAttempts, now()->addHour());
        $this->resendLimitReached = $this->resendAttempts >= 6;
    }

    public function updateResendCooldown()
    {
        if (RateLimiter::tooManyAttempts($this->resendThrottleKey(), 1)) {
            $this->resendCooldown = RateLimiter::availableIn($this->resendThrottleKey());
        } else {
            $this->resendCooldown = null;
        }
    }

    protected function sendOtp(): void
    {
        $user = user();

        if (has_valid_otp($user, OtpType::EMAIL_VERIFICATION)) {
            $this->info('A verification code was already sent to your email.');
            return;
        }

        $otpVerification = create_otp($user, OtpType::EMAIL_VERIFICATION, 10);

        Log::info('OTP Code for User ID ' . $user->id . ': ' . $otpVerification->code);
        $user->notify(new UserOtpNotification($otpVerification->code));

        $this->success('Verification code has been sent to your email.');
    }

    public function verify(): void
    {
        try {
            // Validate using the OtpForm rules
            $this->form->validate();

            $this->ensureIsNotRateLimited();

            $user = user();
            $otpVerification = $user->latestOtp(OtpType::EMAIL_VERIFICATION);

            if (!$otpVerification) {
                throw ValidationException::withMessages([
                    'form.code' => 'No verification code found. Please request a new one.',
                ]);
            }

            if ($otpVerification->isVerified()) {
                throw ValidationException::withMessages([
                    'form.code' => 'This verification code has already been used.',
                ]);
            }

            if ($otpVerification->isExpired()) {
                throw ValidationException::withMessages([
                    'form.code' => 'The verification code has expired. Please request a new one.',
                ]);
            }

            if ($otpVerification->attempts >= 6) {
                throw ValidationException::withMessages([
                    'form.code' => 'Too many failed attempts. Please request a new code.',
                ]);
            }

            if (!verify_otp($user, $this->form->code, OtpType::EMAIL_VERIFICATION)) {
                RateLimiter::hit($this->throttleKey());
                $remainingAttempts = 6 - $otpVerification->fresh()->attempts;

                throw ValidationException::withMessages([
                    'form.code' => "The verification code is incorrect. {$remainingAttempts} attempts remaining.",
                ]);
            }

            $user->markEmailAsVerified();
            RateLimiter::clear($this->throttleKey());

            // Clear resend attempts on successful verification
            cache()->forget('otp_resend_attempts:' . $user->id);

            $this->success('Email verified successfully!');
            $this->dispatch('clear-auth-code');

            $this->redirect(route('user.purchased-orders'), navigate: true);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('OTP verification failed', [
                'user_id' => user()->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error('Something went wrong while verifying your code. Please try again.');
        }
    }

    public function resend(): void
    {
        // Check if limit reached
        if ($this->resendLimitReached) {
            $this->error('Maximum resend limit reached. Please contact support.');
            return;
        }

        $this->ensureResendIsNotRateLimited();

        $user = user();
        $otpVerification = create_otp($user, OtpType::EMAIL_VERIFICATION, 10);

        Log::info('Resent OTP Code for User ID ' . $user->id . ': ' . $otpVerification->code);
        $user->notify(new UserOtpNotification($otpVerification->code));

        // Increment attempts
        $this->incrementResendAttempts();

        // Set  (30 seconds) cooldown
        RateLimiter::hit($this->resendThrottleKey(), 30);
        $this->resendCooldown = 30;

        $this->success('A new verification code has been sent to your email.');
        $this->dispatch('otp-resent', ['attempts' => $this->resendAttempts]);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 6)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.code' => "Too many verification attempts. Please try again in {$seconds} seconds.",
        ]);
    }

    protected function ensureResendIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->resendThrottleKey(), 1)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->resendThrottleKey());

        throw ValidationException::withMessages([
            'form.code' => "Please wait {$seconds} seconds before requesting a new code.",
        ]);
    }

    protected function throttleKey(): string
    {
        return 'otp-verify:' . user()->id . ':' . request()->ip();
    }

    protected function resendThrottleKey(): string
    {
        return 'otp-resend:' . user()->id . ':' . request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.user.verify-otp');
    }
}