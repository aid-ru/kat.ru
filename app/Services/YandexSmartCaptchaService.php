<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YandexSmartCaptchaService
{
    private string $secretKey;
    private string $clientKey;

    public function __construct()
    {
        $this->secretKey = config('services.yandex_smartcaptcha.secret_key');
        $this->clientKey = config('services.yandex_smartcaptcha.client_key');
    }

    public function verify(string $token, string $userIP = null): bool
    {
        try {
            $response = Http::asForm()->post('https://captcha-api.yandex.ru/validate', [
                'secret' => $this->secretKey,
                'token' => $token,
                'ip' => $userIP ?? request()->ip(),
            ]);

            $data = $response->json();

            if (isset($data['status']) && $data['status'] === 'ok') {
                return true;
            }

            Log::warning('Yandex SmartCaptcha validation failed', [
                'response' => $data,
                'user_ip' => $userIP ?? request()->ip(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Yandex SmartCaptcha validation error', [
                'error' => $e->getMessage(),
                'user_ip' => $userIP ?? request()->ip(),
            ]);

            return false;
        }
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }
}