<?php

namespace App\Rules;

use App\Services\YandexSmartCaptchaService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YandexSmartCaptchaRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $captchaService = app(YandexSmartCaptchaService::class);
        
        if (!$captchaService->verify($value)) {
            $fail('Капча не пройдена. Пожалуйста, попробуйте снова.');
        }
    }
}