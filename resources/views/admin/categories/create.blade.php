<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">{{ __('categories.create_title') }}</h2></x-slot>
    <div class="max-w-3xl mx-auto py-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm">{{ __('categories.name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div>
                <label class="block text-sm">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded px-3 py-2" required>
                <x-input-error :messages="$errors->get('slug')" />
            </div>
            <div>
                <label class="block text-sm">{{ __('categories.description') }}</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>
            <div class="flex items-center gap-4">
                <div>
                    <label class="block text-sm">{{ __('categories.position') }}</label>
                    <input type="number" name="position" value="{{ old('position', 0) }}" class="w-24 border rounded px-3 py-2">
                </div>
                <label class="inline-flex items-center mt-6"><input type="checkbox" name="is_active" value="1" checked class="mr-2"> {{ __('categories.active') }}</label>
            </div>
            <div class="pt-4">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">{{ __('buttons.save') }}</button>
                <a href="{{ route('admin.categories.index') }}" class="ml-2 text-gray-600">{{ __('buttons.cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
