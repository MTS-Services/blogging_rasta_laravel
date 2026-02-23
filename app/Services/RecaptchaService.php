<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RecaptchaService
{
    public function verify(string $token, ?string $remoteIp = null): bool
    {
        $secret = config('recaptcha.secret_key');
        if (empty($secret)) {
            return false;
        }

        $response = Http::asForm()->post(config('recaptcha.verify_url'), [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $remoteIp ?? request()?->ip(),
        ]);

        if (! $response->successful()) {
            return false;
        }

        $body = $response->json();
        return (bool) ($body['success'] ?? false);
    }
}
