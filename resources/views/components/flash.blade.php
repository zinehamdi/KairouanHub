@props(['type' => 'success'])

@if (session($type))
    <div class="max-w-7xl mx-auto mt-4">
        <div class="p-3 rounded {{ $type==='success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ session($type) }}
        </div>
    </div>
@endif
