@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <h1 class="text-4xl font-bold text-brand-dark mb-8">مقدمو الخدمات في القيروان</h1>
    
    @if($providers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($providers as $provider)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold">{{ $provider->display_name }}</h3>
                    <p class="text-gray-600">{{ $provider->city }}</p>
                    <a href="{{ route('providers.show', $provider->id) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                        View Profile
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $providers->links() }}
        </div>
    @else
        <p>No providers found.</p>
    @endif
</div>
@endsection
