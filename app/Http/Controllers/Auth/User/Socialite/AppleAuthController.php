<?php

namespace App\Http\Controllers\Auth\User\Socialite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AppleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('apple')
            ->scopes(['name', 'email'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $appleUser = Socialite::driver('apple')->user();

            // Find or create user
            $user = User::where('apple_id', $appleUser->$this->id)
                ->orWhere('email', $appleUser->$this->email)
                ->first();

            if (!$user) {
                // Apple only provides name on first login
                $name = $appleUser->name ?? 'Apple User';

                $user = User::create([
                    'name' => $name,
                    'email' => $appleUser->email ?? $appleUser->$this->id . '@privaterelay.appleid.com',
                    'apple_id' => $appleUser->$this->id,
                    'password' => bcrypt(Str::random(24)), // Random password
                ]);
            } else {
                // Update apple_id if user exists with same email
                if (!$user->apple_id) {
                    $user->update(['apple_id' => $appleUser->$this->id]);
                }
            }

            Auth::login($user, true);

            return redirect()->intended('user/orders/purchased-orders');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to login with Apple. Please try again.');
        }
    }
}
