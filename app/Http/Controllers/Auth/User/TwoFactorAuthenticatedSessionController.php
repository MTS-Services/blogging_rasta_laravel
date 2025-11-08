<?php

namespace App\Http\Controllers\Auth\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Events\RecoveryCodeReplaced;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $guard = Auth::guard('web');
        
        // Check if there's a challenged user in session
        if (!$request->session()->has('login.id')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Your session has expired. Please login again.',
            ]);
        }

        // Get the user model
        $model = config('auth.providers.users.model');
        $user = $model::find($request->session()->get('login.id'));

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to find user. Please login again.',
            ]);
        }

        if (!$user->two_factor_secret) {
            return redirect()->route('login')->withErrors([
                'email' => 'Two-factor authentication is not enabled.',
            ]);
        }

        // Validate that at least one field is provided
        $request->validate([
            'code' => 'nullable|string|size:6|required_without:recovery_code',
            'recovery_code' => 'nullable|string|required_without:code',
        ], [
            'code.required_without' => 'Please provide an authentication code or recovery code.',
            'recovery_code.required_without' => 'Please provide an authentication code or recovery code.',
        ]);

        // Check if recovery code is provided
        if ($request->filled('recovery_code')) {
            $result = $this->verifyRecoveryCode($user, $request->input('recovery_code'));
            
            if (!$result['valid']) {
                return back()->withErrors([
                    'recovery_code' => $result['message'],
                ]);
            }
        } 
        // Check if 2FA code is provided
        elseif ($request->filled('code')) {
            $result = $this->verifyTwoFactorCode($user, $request->input('code'));
            
            if (!$result['valid']) {
                return back()->withErrors([
                    'code' => $result['message'],
                ]);
            }
        }

        // Login the user
        $guard->login($user, $request->session()->get('login.remember', false));

        $request->session()->regenerate();
        
        // Clear the login session data
        $request->session()->forget(['login.id', 'login.remember']);

        return redirect()->intended(route('user.purchased-orders', absolute: false));
    }

    /**
     * Verify the two-factor authentication code
     */
    private function verifyTwoFactorCode($user, $code)
    {
        try {
            $google2fa = app(Google2FA::class);
            
            $decryptedSecret = decrypt($user->two_factor_secret);
            
            $valid = $google2fa->verifyKey($decryptedSecret, $code);

            if (!$valid) {
                return [
                    'valid' => false,
                    'message' => 'The provided two-factor authentication code was invalid.',
                ];
            }

            return ['valid' => true];
        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'An error occurred while verifying the code.',
            ];
        }
    }

    /**
     * Verify and use a recovery code
     */
    private function verifyRecoveryCode($user, $recoveryCode)
    {
        try {
            if (!$user->two_factor_recovery_codes) {
                return [
                    'valid' => false,
                    'message' => 'No recovery codes available.',
                ];
            }

            // Clean up the recovery code (remove spaces, dashes, underscores)
            $recoveryCode = str_replace([' ', '-', '_'], '', $recoveryCode);
            $recoveryCode = strtolower(trim($recoveryCode));
            
            Log::info('User recovery code verification attempt', [
                'user_id' => $user->id,
                'recovery_code_input' => $recoveryCode,
            ]);

            // Decrypt and parse recovery codes
            $decryptedCodes = decrypt($user->two_factor_recovery_codes);
            $recoveryCodes = json_decode($decryptedCodes, true);

            if (!is_array($recoveryCodes)) {
                Log::error('User recovery codes format invalid', ['user_id' => $user->id]);
                return [
                    'valid' => false,
                    'message' => 'Recovery codes format is invalid.',
                ];
            }

            // Normalize all codes to lowercase for comparison
            $normalizedCodes = array_map(function($code) {
                return strtolower(str_replace([' ', '-', '_'], '', $code));
            }, $recoveryCodes);

            Log::info('Available user recovery codes count', [
                'user_id' => $user->id,
                'count' => count($normalizedCodes),
            ]);

            // Check if the code exists in the list (case-insensitive)
            $codeKey = array_search($recoveryCode, $normalizedCodes);
            
            if ($codeKey === false) {
                Log::warning('User recovery code not found', [
                    'user_id' => $user->id,
                    'provided' => $recoveryCode,
                    'available' => implode(', ', array_slice($normalizedCodes, 0, 2)) . '...',
                ]);
                return [
                    'valid' => false,
                    'message' => 'The provided recovery code was invalid or has already been used.',
                ];
            }

            // Remove the used code from the array
            unset($recoveryCodes[$codeKey]);

            // Update the recovery codes in the database
            $user->two_factor_recovery_codes = encrypt(json_encode(array_values($recoveryCodes)));
            $user->save();

            // Fire event for recovery code replacement
            event(new RecoveryCodeReplaced($user, $recoveryCode));

            Log::info('User recovery code used successfully', [
                'user_id' => $user->id,
                'remaining_codes' => count($recoveryCodes),
            ]);

            return ['valid' => true];
        } catch (\Exception $e) {
            Log::error('User recovery code verification error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'exception' => get_class($e),
            ]);
            
            return [
                'valid' => false,
                'message' => 'An error occurred while verifying the recovery code.',
            ];
        }
    }
}