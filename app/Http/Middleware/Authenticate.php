<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (!$request->expectsJson()) {
            // Check if this is an admin route
            if ($request->is('admin') || $request->is('admin/*')) {
                
                return redirect()->route('admin.login');
            }
            
            // Default to user login
            return redirect()->route('login');
        }

        return $next($request);
    }
}
