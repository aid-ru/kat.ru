<?php

namespace App\Rules;

use App\Services\ReCaptchaService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ReCaptcha implements ValidationRule
{
    protected $recaptchaService;

    public function __construct()
    {
        $this->recaptchaService = new ReCaptchaService();
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->recaptchaService->isEnabled()) {
            // If reCAPTCHA is not configured, skip validation
            return;
        }

        if (!$this->recaptchaService->verify($value)) {
            $fail('The :attribute is invalid.')->translate();
        }
    }
}