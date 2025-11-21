<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'fr'; 

        $langFiles = File::glob(base_path('lang') . '/*.json');
        $supportedLocales = [];
        foreach ($langFiles as $file) {
            $supportedLocales[] = pathinfo($file, PATHINFO_FILENAME);
        }

        if (session()->has('locale')) {
            $sessionLocale = session()->get('locale');
            if (in_array($sessionLocale, $supportedLocales)) {
                $locale = $sessionLocale;
            }
        }

        App::setLocale($locale);

        return $next($request);
    }
}