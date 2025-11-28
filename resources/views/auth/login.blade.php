<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني / Email" class="text-brand-dark font-bold" />
            <x-text-input id="email" class="input-mediterranean mt-1 block w-full" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="كلمة المرور / Password" class="text-brand-dark font-bold" />
            <x-text-input id="password" class="input-mediterranean mt-1 block w-full" type="password" name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-accent-DEFAULT shadow-sm focus:ring-terracotta focus:ring-2"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-accent-DEFAULT hover:text-mediterranean-blue font-medium transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="btn-terracotta">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                ليس لديك حساب؟
                <a href="{{ route('register') }}"
                    class="text-accent-DEFAULT hover:text-mediterranean-blue font-bold transition-colors">
                    سجل الآن
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>