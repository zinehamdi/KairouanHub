<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="الاسم / Name" class="text-brand-dark font-bold" />
            <x-text-input id="name" class="input-mediterranean mt-1 block w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني / Email" class="text-brand-dark font-bold" />
            <x-text-input id="email" class="input-mediterranean mt-1 block w-full" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="كلمة المرور / Password" class="text-brand-dark font-bold" />
            <x-text-input id="password" class="input-mediterranean mt-1 block w-full" type="password" name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="تأكيد كلمة المرور / Confirm Password"
                class="text-brand-dark font-bold" />
            <x-text-input id="password_confirmation" class="input-mediterranean mt-1 block w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-4">
            <a class="text-sm text-accent-DEFAULT hover:text-mediterranean-blue font-medium transition-colors"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="btn-terracotta">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>