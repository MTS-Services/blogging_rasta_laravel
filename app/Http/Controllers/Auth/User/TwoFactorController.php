<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    /**
     * Show 2FA settings page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('frontend.user.two-factor.index', [
            'user' => $user,
            'twoFactorEnabled' => !is_null($user->two_factor_secret),
        ]);
    }

    /**
     * Get QR code
     */
    public function show()
    {
        $user = Auth::user();
        
        return response()->json([
            'svg' => $user->twoFactorQrCodeSvg(),
            'url' => $user->twoFactorQrCodeUrl(),
        ]);
    }

    /**
     * Get recovery codes
     */
    public function codes()
    {
        $user = Auth::user();
        
        if (is_null($user->two_factor_recovery_codes)) {
            return response()->json([]);
        }
        
        return response()->json(
            json_decode(decrypt($user->two_factor_recovery_codes), true)
        );
    }
}
