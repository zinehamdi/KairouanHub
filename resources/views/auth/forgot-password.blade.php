<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('auth.forgot_password_text') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('auth.email')" class="text-brand-dark font-bold" />
            <x-text-input id="email" class="input-mediterranean block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="btn-terracotta">
                {{ __('auth.send_reset_link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>