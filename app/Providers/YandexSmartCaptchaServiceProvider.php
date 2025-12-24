<?php

namespace App\Providers;

use App\Services\YandexSmartCaptchaService;
use Illuminate\Support\ServiceProvider;

class YandexSmartCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(YandexSmartCaptchaService::class, function () {
            return new YandexSmartCaptchaService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}