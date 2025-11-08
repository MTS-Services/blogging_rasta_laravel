<?php

namespace App\Livewire\Auth\Admin;

use App\Enums\OtpType;
use App\Livewire\Forms\Auth\Otp\OtpForm;
use App\Models\Admin;
use App\Notifications\AdminOtpNotification;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class VerifyResetOtp extends Component
{
    use WithNotification;

    public OtpForm $form;
    public string $email = '';
    public ?int $resendCooldown = null;

    public function mount()
    {
        // Get email from session
        $this->email = session('password_reset_email');

        if (!$this->email) {
            $this->error('Session expired. Please start the password reset process again.');
            $this->redirect(route('admin.password.request'), navigate: true);
            return;
        }

        // Check if there's an active cooldown
        $this->updateResendCooldown();
    }

    public function updateResendCooldown()
    {
        if (RateLimiter::tooManyAttempts($this->resendThrottleKey(), 1)) {
            $this->resendCooldown = RateLimiter::availableIn($this->resendThrottleKey());
        } else {
            $this->resendCooldown = null;
        }
    }

    public function verifyOtp(): void
    {
        try {
            $this->form->validate();

            $this->ensureIsNotRateLimited();
            
            $admin = Admin::where('email', $this->email)->first();

            if (!$admin) {
                throw ValidationException::withMessages([
                    'form.code' => 'Invalid verification code.',
                ]);
            }

            $otpVerification = $admin->latestOtp(OtpType::PASSWORD_RESET); 
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

            if ($otpVerification->attempts >= 5) {
                throw ValidationException::withMessages([
                    'form.code' => 'Too many failed attempts. Please request a new code.',
                ]);
            }

            if (!verify_otp($admin, $this->form->code, OtpType::PASSWORD_RESET)) {
                RateLimiter::hit($this->throttleKey());
                $remainingAttempts = 5 - $otpVerification->fresh()->attempts;

                throw ValidationException::withMessages([
                    'form.code' => "The verification code is incorrect. {$remainingAttempts} attempts remaining.",
                ]);
            }

            RateLimiter::clear($this->throttleKey());

            $this->success('Verification successful! Redirecting to reset password...');
            $this->dispatch('clear-auth-code');

            // Create encrypted token with only email
            $token = encrypt([
                'email' => $admin->email,
                'expires_at' => now()->addMinutes(15)->timestamp,
            ]);

            // Clear email from session
            session()->forget('password_reset_email');

            $this->redirect(route('admin.password.reset', ['token' => $token]), navigate: true);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Password reset OTP verification failed', [
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error('Something went wrong while verifying your code. Please try again.');
        }
    }

    public function resendOtp(): void
    {
        $this->ensureResendIsNotRateLimited();

        $admin = Admin::where('email', $this->email)->first();

        if (!$admin) {
            $this->success('If an account exists, a verification code has been sent to your email.');
            return;
        }

        $otpVerification = create_otp($admin, OtpType::PASSWORD_RESET, 10);

        Log::info('Resent Password Reset OTP for Admin: ' . $admin->email . ' - Code: ' . $otpVerification->code);
        $admin->notify(new AdminOtpNotification($otpVerification->code));

        // Set 30 second cooldown
        RateLimiter::hit($this->resendThrottleKey(), 30);
        $this->resendCooldown = 30;

        $this->success('A new verification code has been sent to your email.');
        $this->dispatch('otp-resent');
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        return 'password-reset-verify:' . $this->email . ':' . request()->ip();
    }

    protected function resendThrottleKey(): string
    {
        return 'password-reset-resend:' . $this->email . ':' . request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.admin.verify-reset-otp');
    }
}