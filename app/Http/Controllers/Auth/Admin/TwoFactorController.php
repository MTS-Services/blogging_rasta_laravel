<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        
        return view('frontend.admin.two-factor.index', [
            'admin' => $admin,
            'twoFactorEnabled' => !is_null($admin->two_factor_secret),
        ]);
    }

    public function show()
    {
        return response()->json([
            'svg' => Auth::guard('admin')->user()->twoFactorQrCodeSvg(),
            'url' => Auth::guard('admin')->user()->twoFactorQrCodeUrl(),
        ]);
    }

    public function codes()
    {
        $admin = Auth::guard('admin')->user();
        
        return response()->json(
            json_decode(decrypt($admin->two_factor_recovery_codes), true)
        );
    }
}