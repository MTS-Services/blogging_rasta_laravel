<?php

namespace App\Livewire\Auth\User;

use App\Enums\OtpType;
use App\Models\User;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ResetPassword extends Component
{
    use WithNotification;

    #[Locked]
    public string $token = '';

    #[Locked]
    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        // Decrypt and validate the token
        $data = decrypt($token);

        // Validate token structure
        if (!isset($data['email'], $data['expires_at'])) {
            $this->error('Invalid password reset link. Please request a new one.');
            $this->redirect(route('password.request'), navigate: true);
            return;
        }

        // Check if token has expired
        if ($data['expires_at'] < now()->timestamp) {
            $this->error('This password reset link has expired. Please request a new one.');
            $this->redirect(route('password.request'), navigate: true);
            return;
        }

        // Verify user exists
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            $this->error('Invalid password reset link. Please request a new one.');
            $this->redirect(route('password.request'), navigate: true);
            return;
        }

        // Verify OTP was actually verified
        $otpVerification = $user->latestOtp(OtpType::PASSWORD_RESET);
        if (!$otpVerification || !$otpVerification->isVerified()) {
            $this->error('Verification required. Please complete the verification process first.');
            $this->redirect(route('password.request'), navigate: true);
            return;
        }

        $this->token = $token;
        $this->email = $data['email'];
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        try {
            $this->validate([
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]);

            // Find the user by email
            $user = User::where('email', $this->email)->first();

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Verify OTP is still verified
            $otpVerification = $user->latestOtp(OtpType::PASSWORD_RESET);
            if (!$otpVerification || !$otpVerification->isVerified()) {
                throw ValidationException::withMessages([
                    'password' => 'Your verification has expired. Please restart the password reset process.',
                ]);
            }

            // Check if new password is same as current password
            if (Hash::check($this->password, $user->password)) {
                throw ValidationException::withMessages([
                    'password' => 'Your new password cannot be the same as your current password. Please choose a different password.',
                ]);
            }

            // Update password
            $user->forceFill([
                'password' => Hash::make($this->password),
            ])->save();

            // Mark OTP as used by deleting it
            $otpVerification->delete();

            Log::info('Password successfully reset for User: ' . $user->email);

            $this->success('Your password has been reset successfully. Please log in with your new password.');
            
            $this->redirect(route('login'), navigate: true);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Password reset failed', [
                'email' => $this->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->error('Something went wrong while resetting your password. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.user.reset-password');
    }
}