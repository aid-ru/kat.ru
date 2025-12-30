<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="smart-captcha-form" onsubmit="handleSubmit(event)">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-500 text-gray-500 dark:focus:ring-blue-500 focus:ring-sky-500" name="remember">
                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Капча -->
        <div id="captcha-container"></div>
        @error('smart-token')
            <div class="text-sm text-red-600 mt-1" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-500 dark:hover:text-gray-100 hover:text-gray-900 rounded-md" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <a href="https://yandex.com/legal/smartcaptcha_notice/en/" target="_blank" class="underline text-xs text-gray-500 dark:hover:text-gray-100 hover:text-gray-900">Политика конфиденциальности</a>

    @include('auth/smart-captcha-scripts')
</x-guest-layout>
