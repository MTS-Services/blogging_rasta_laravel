<?php

namespace App\Livewire\Auth\Admin;

use App\Enums\OtpType;
use App\Models\Admin;
use App\Notifications\AdminOtpNotification;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ForgotPassword extends Component
{
    use WithNotification;

    public string $email = '';

    public function sendPasswordResetOtp(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'exists:admins,email'],
        ]);

        $this->ensureSendIsNotRateLimited();

        $admin = Admin::where('email', $this->email)->first();

        if (!$admin) {
            // Security: Don't reveal if email exists
            $this->success('If an account exists, a verification code has been sent to your email.');
            
            // Redirect to verify page anyway for security
            session(['password_reset_email' => $this->email]);
            $this->redirect(route('admin.reset.verify-otp'), navigate: true);
            return;
        }

        if (has_valid_otp($admin, OtpType::PASSWORD_RESET)) {
            $this->info('A verification code was already sent to your email.');
            session(['password_reset_email' => $this->email]);
            $this->redirect(route('admin.reset.verify-otp'), navigate: true);
            return;
        }

        $otpVerification = create_otp($admin, OtpType::PASSWORD_RESET, 10);

        Log::info('Password Reset OTP for Admin ID ' . $admin->id . ': ' . $otpVerification->code);
        $admin->notify(new AdminOtpNotification($otpVerification->code));

        RateLimiter::hit($this->sendThrottleKey(), 60);

        session(['password_reset_email' => $this->email]);

        $this->success('Verification code has been sent to your email.');
        $this->redirect(route('admin.reset.verify-otp'), navigate: true);
    }

    protected function ensureSendIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->sendThrottleKey(), 1)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->sendThrottleKey());

        throw ValidationException::withMessages([
            'email' => "Please wait {$seconds} seconds before requesting a new code.",
        ]);
    }

    protected function sendThrottleKey(): string
    {
        return 'password-reset-send:' . $this->email . ':' . request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.admin.forgot-password');
    }
}