<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">{{ __('services.create_title') }}</h2></x-slot>
    <div class="max-w-3xl mx-auto py-6">
        <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm">{{ __('services.name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div>
                <label class="block text-sm">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded px-3 py-2" required>
                <x-input-error :messages="$errors->get('slug')" />
            </div>
            <div>
                <label class="block text-sm">{{ __('categories.name') }}</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id')==$cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" />
            </div>
            <div>
                <label class="block text-sm">{{ __('services.summary') }}</label>
                <textarea name="summary" class="w-full border rounded px-3 py-2">{{ old('summary') }}</textarea>
            </div>
            <label class="inline-flex items-center"><input type="checkbox" name="is_active" value="1" checked class="mr-2"> {{ __('services.active') }}</label>
            <div class="pt-4">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">{{ __('buttons.save') }}</button>
                <a href="{{ route('admin.services.index') }}" class="ml-2 text-gray-600">{{ __('buttons.cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
