<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReCaptchaService
{
    protected $siteKey;
    protected $secretKey;
    protected $version;
    protected $options;

    public function __construct()
    {
        $this->siteKey = config('recaptcha.api_site_key');
        $this->secretKey = config('recaptcha.api_secret_key');
        $this->version = config('recaptcha.version', 3);
        $this->options = config('recaptcha.options', []);
    }

    /**
     * Verify the reCAPTCHA response
     *
     * @param string|null $response
     * @param string|null $clientIp
     * @return bool
     */
    public function verify($response = null, $clientIp = null): bool
    {
        // Skip validation for specific IPs
        if (in_array(request()->ip(), $this->options['skip_ips'])) {
            return true;
        }

        // If no response is provided, check the input
        if (!$response) {
            $response = request()->get('g-recaptcha-response') ?: request()->get('recaptcha_response');
        }

        if (!$response) {
            Log::warning('reCAPTCHA response not provided');
            return false;
        }

        if (!$this->secretKey) {
            Log::error('reCAPTCHA secret key not configured');
            return false;
        }

        try {
            $verifyUrl = config('recaptcha.verify_url.' . $this->version);

            $data = [
                'secret' => $this->secretKey,
                'response' => $response,
            ];

            if ($clientIp) {
                $data['remoteip'] = $clientIp;
            }

            $response = Http::asForm()->timeout($this->options['curl_timeout'])->post($verifyUrl, $data);

            if (!$response->successful()) {
                Log::error('reCAPTCHA verification request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }

            $result = $response->json();

            if (!isset($result['success']) || !$result['success']) {
                Log::warning('reCAPTCHA verification failed', ['errors' => $result['error-codes'] ?? []]);
                return false;
            }

            // For reCAPTCHA v3, we also check the score
            if ($this->version == 3 && isset($result['score'])) {
                $minimumScore = config('recaptcha.minimum_score', 0.5);
                if ($result['score'] < $minimumScore) {
                    Log::warning('reCAPTCHA score too low', ['score' => $result['score'], 'minimum' => $minimumScore]);
                    return false;
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', ['exception' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Get the reCAPTCHA script tag
     *
     * @param string|null $callback
     * @param string|null $badgePosition
     * @return string
     */
    public function renderScript($callback = null, $badgePosition = null): string
    {
        if (!$this->siteKey) {
            return '';
        }

        $scriptUrl = config('recaptcha.script_url.' . $this->version);
        
        $params = [
            'render' => $this->siteKey
        ];

        if ($this->version == 2 && $callback) {
            $params['onload'] = $callback;
        }

        if ($this->version == 3) {
            if ($callback) {
                $params['onload'] = $callback;
            }
            $params['render'] = 'explicit';
        }

        $queryString = http_build_query($params);
        $scriptSrc = $scriptUrl . '?' . $queryString;

        $html = '<script src="' . $scriptSrc . '" async defer></script>';
        
        // Add badge styling if needed
        if ($this->version == 3 && $badgePosition) {
            $html .= '<style>.grecaptcha-badge { bottom: ' . $badgePosition . ' !important; }</style>';
        }

        return $html;
    }

    /**
     * Render reCAPTCHA v3 element
     *
     * @param string $action
     * @param string $id
     * @return string
     */
    public function renderV3($action = 'homepage', $id = 'g-recaptcha'): string
    {
        if ($this->version != 3) {
            return '';
        }

        return '<div id="' . $id . '" style="display:none;"></div>
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute("' . $this->siteKey . '", {action: "' . $action . '"})
                        .then(function(token) {
                            document.getElementById("g-recaptcha-response").value = token;
                        });
                });
            });
        </script>';
    }

    /**
     * Check if reCAPTCHA is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return !empty($this->siteKey) && !empty($this->secretKey);
    }
}