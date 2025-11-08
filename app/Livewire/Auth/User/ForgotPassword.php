<?php

namespace App\Livewire\Auth\User;

use App\Enums\OtpType;
use App\Models\User;
use App\Notifications\UserOtpNotification;
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
            'email' => ['required', 'string', 'email', 'exists:users,email'],
        ]);


        $this->ensureSendIsNotRateLimited();

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            // Security: Don't reveal if email exists
            $this->success('If an account exists, a verification code has been sent to your email.');

            // Redirect to verify page anyway for security
            session(['password_reset_email' => $this->email]);
            $this->redirect(route('verify-reset-otp'), navigate: true);
            return;
        }

        if (has_valid_otp($user, OtpType::PASSWORD_RESET)) {
            $this->info('A verification code was already sent to your email.');
            session(['password_reset_email' => $this->email]);
            $this->redirect(route('verify-reset-otp'), navigate: true);
            return;
        }

        $otpVerification = create_otp($user, OtpType::PASSWORD_RESET, 10);

        Log::info('Password Reset OTP for User ID ' . $user->id . ': ' . $otpVerification->code);
        $user->notify(new UserOtpNotification($otpVerification->code));

        RateLimiter::hit($this->sendThrottleKey(), 60);

        session(['password_reset_email' => $this->email]);

        $this->success('Verification code has been sent to your email.');
        $this->redirect(route('verify-reset-otp'), navigate: true);
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
        return view('livewire.auth.user.forgot-password');
    }
}
