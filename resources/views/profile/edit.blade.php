<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-deep-blue">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-soft-cream min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card-mediterranean p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card-mediterranean p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card-mediterranean p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>