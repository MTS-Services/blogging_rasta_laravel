<?php

namespace App\Livewire\Auth\Admin;

use App\Enums\OtpType;
use App\Models\Admin;
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
            $this->redirect(route('admin.password.request'), navigate: true);
            return;
        }

        // Check if token has expired
        if ($data['expires_at'] < now()->timestamp) {
            $this->error('This password reset link has expired. Please request a new one.');
            $this->redirect(route('admin.password.request'), navigate: true);
            return;
        }

        // Verify admin exists
        $admin = Admin::where('email', $data['email'])->first();
        if (!$admin) {
            $this->error('Invalid password reset link. Please request a new one.');
            $this->redirect(route('admin.password.request'), navigate: true);
            return;
        }

        // Verify OTP was actually verified
        $otpVerification = $admin->latestOtp(OtpType::PASSWORD_RESET);
        if (!$otpVerification || !$otpVerification->isVerified()) {
            $this->error('Verification required. Please complete the verification process first.');
            $this->redirect(route('admin.password.request'), navigate: true);
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

            // Find the admin by email
            $admin = Admin::where('email', $this->email)->first();

            if (!$admin) {
                throw new \Exception('Admin not found');
            }

            // Verify OTP is still verified
            $otpVerification = $admin->latestOtp(OtpType::PASSWORD_RESET);
            if (!$otpVerification || !$otpVerification->isVerified()) {
                throw ValidationException::withMessages([
                    'password' => 'Your verification has expired. Please restart the password reset process.',
                ]);
            }

            // Check if new password is same as current password
            if (Hash::check($this->password, $admin->password)) {
                throw ValidationException::withMessages([
                    'password' => 'Your new password cannot be the same as your current password. Please choose a different password.',
                ]);
            }

            // Update password
            $admin->forceFill([
                'password' => Hash::make($this->password),
            ])->save();

            // Mark OTP as used by deleting it
            $otpVerification->delete();

            Log::info('Password successfully reset for Admin: ' . $admin->email);

            $this->success('Your password has been reset successfully. Please log in with your new password.');
            
            $this->redirect(route('admin.login'), navigate: true);

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
        return view('livewire.auth.admin.reset-password');
    }
}