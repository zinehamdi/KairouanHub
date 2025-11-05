@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-semibold mb-6">{{ __('requests.create.title') }}</h1>
    @guest
        <x-card class="p-6">
            <p class="mb-4 text-sm">{{ __('auth.login') }} / {{ __('auth.register') }}</p>
            <a href="{{ route('login') }}" class="text-blue-600 underline">Login</a>
        </x-card>
    @else
        <x-card class="p-6" x-data="{cat:'',filter(){}, services: {{ json_encode(App\Models\Service::select('id','name','category_id')->orderBy('name')->get()) }} }">
            <form method="POST" action="{{ route('requests.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">{{ __('requests.create.select_category') }}</label>
                    <select name="category_id" x-model="cat" required class="mt-1 w-full border rounded p-2">
                        <option value="">--</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">{{ __('requests.create.select_service') }}</label>
                    <select name="service_id" class="mt-1 w-full border rounded p-2">
                        <option value="">--</option>
                        <template x-for="s in services.filter(v=>!cat || v.category_id==cat)" :key="s.id">
                            <option :value="s.id" x-text="s.name"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">{{ __('requests.create.city') }}</label>
                    <input name="city" required maxlength="120" class="mt-1 w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium">{{ __('requests.create.details') }}</label>
                    <textarea name="details" required maxlength="2000" rows="5" class="mt-1 w-full border rounded p-2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">{{ __('requests.create.photos') }}</label>
                    <input type="file" name="photos[]" multiple accept="image/*" class="mt-1 w-full" />
                    <p class="text-xs text-gray-500 mt-1">{{ __('requests.create.hint_photos') }}</p>
                </div>
                <p class="text-xs text-gray-400">{{ __('requests.create.hint_required') }}</p>
                <div>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">{{ __('requests.create.submit') }}</button>
                </div>
            </form>
        </x-card>
    @endguest
</div>
@endsection
