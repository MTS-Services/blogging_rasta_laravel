<?php

namespace App\Resolvers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use OwenIt\Auditing\Contracts\UserResolver as UserResolverContract;

class MultiGuardUserResolver implements UserResolverContract
{
    /**
     * Resolve the User with guard information.
     *
     * @return mixed|null
     */
    public static function resolve()
    {
        $guards = Config::get('audit.user.guards', ['web', 'admin']);

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }

        return null;
    }
}
