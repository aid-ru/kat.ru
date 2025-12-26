<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class YandexCaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            // Это никогда не должно срабатывать, так как required проверяется отдельно
            return;
        }

        $serverKey = env('YANDEX_SMART_CAPTCHA_SERVER_KEY');
        $ip = Request::ip();
        
        try {
            $response = Http::timeout(3)
                ->get('https://smartcaptcha.yandexcloud.net/validate', [
                    'secret' => $serverKey,
                    'token' => $value,
                    'ip' => $ip,
                ]);

            // При ошибках связи разрешаем доступ (как в оригинальном коде Яндекса)
            if (!$response->successful()) {
                Log::warning('Yandex SmartCaptcha validation failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return;
            }

            $result = $response->json();
            if ($result['status'] !== 'ok') {
                $fail('Ошибка проверки капчи. Попробуйте еще раз.');
            }
            
        } catch (\Exception $e) {
            // При ошибках связи разрешаем доступ (как в оригинальном коде Яндекса)
            Log::error('Yandex SmartCaptcha error', ['exception' => $e->getMessage()]);
        }
    }
}