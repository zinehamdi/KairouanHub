@extends('layouts.admin')

@section('admin-content')
	<div class="py-8 px-4 sm:px-6 lg:px-8">
		<div class="max-w-4xl mx-auto">
			{{-- Header --}}
			<div class="mb-8">
				<div class="flex items-center gap-4 mb-4">
					<a href="{{ route('admin.providers.index') }}"
						class="text-white bg-gradient-to-r from-[#E07A5F] to-[#F4A261] hover:from-[#F4A261] hover:to-[#E07A5F] p-2 rounded-lg transition-all">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M10 19l-7-7m0 0l7-7m-7 7h18" />
						</svg>
					</a>
					<div>
						<h1 class="text-3xl font-bold text-brand-dark">
							{{ $provider->display_name ?? $provider->user->name }}</h1>
						<p class="text-gray-600 mt-1">تفاصيل مزود الخدمة</p>
					</div>
				</div>
			</div>

			@if(session('success'))
				<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
					<span class="text-green-800 font-medium">{{ session('success') }}</span>
				</div>
			@endif

			@if(session('error'))
				<div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
					<span class="text-red-800 font-medium">{{ session('error') }}</span>
				</div>
			@endif

			{{-- Provider Info Card --}}
			<div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
				<div class="flex items-start gap-6 mb-6">
					{{-- Avatar --}}
					<div class="flex-shrink-0">
						@if($provider->avatar)
							<img src="{{ asset('storage/' . $provider->avatar) }}" alt="{{ $provider->display_name }}"
								class="w-24 h-24 rounded-full object-cover border-4 border-accent-DEFAULT/20">
						@else
							<div
								class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-DEFAULT to-accent-dark flex items-center justify-center text-white text-3xl font-bold">
								{{ substr($provider->display_name ?? $provider->user->name ?? 'P', 0, 1) }}
							</div>
						@endif
					</div>

					{{-- Basic Info --}}
					<div class="flex-1">
						<h2 class="text-2xl font-bold text-brand-dark">
							{{ $provider->display_name ?? $provider->user->name }}</h2>
						<p class="text-gray-600">{{ $provider->user->email ?? 'N/A' }}</p>

						{{-- Status Badge --}}
						<div class="mt-2">
							@if($provider->status === 'approved')
								<span
									class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
									✓ Approved
								</span>
							@elseif($provider->status === 'pending')
								<span
									class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
									⏳ Pending
								</span>
							@else
								<span
									class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
									✗ {{ ucfirst($provider->status ?? 'Unknown') }}
								</span>
							@endif

							@if($provider->badge_level)
								<span
									class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-accent-DEFAULT/20 text-accent-dark">
									{{ ucfirst($provider->badge_level) }}
								</span>
							@endif
						</div>
					</div>
				</div>

				{{-- Details Grid --}}
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<label class="block text-sm font-semibold text-gray-500 mb-1">Phone</label>
						<p class="text-lg text-brand-dark">{{ $provider->phone ?? 'N/A' }}</p>
					</div>
					<div>
						<label class="block text-sm font-semibold text-gray-500 mb-1">City</label>
						<p class="text-lg text-brand-dark">{{ $provider->city ?? 'N/A' }}</p>
					</div>
					<div>
						<label class="block text-sm font-semibold text-gray-500 mb-1">Category</label>
						<p class="text-lg text-brand-dark">{{ $provider->category->name ?? 'N/A' }}</p>
					</div>
					<div>
						<label class="block text-sm font-semibold text-gray-500 mb-1">Rating</label>
						<p class="text-lg text-brand-dark">
							@if($provider->avg_rating)
								⭐ {{ number_format($provider->avg_rating, 1) }}/5
							@else
								No ratings yet
							@endif
						</p>
					</div>
				</div>

				@if($provider->bio)
					<div class="mt-6">
						<label class="block text-sm font-semibold text-gray-500 mb-1">Bio</label>
						<p class="text-brand-dark">{{ $provider->bio }}</p>
					</div>
				@endif

				@if($provider->website)
					<div class="mt-4">
						<label class="block text-sm font-semibold text-gray-500 mb-1">Website</label>
						<a href="{{ $provider->website }}" target="_blank" class="text-accent-DEFAULT hover:underline">
							{{ $provider->website }}
						</a>
					</div>
				@endif
			</div>

			{{-- Services --}}
			@if($provider->services->count() > 0)
				<div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
					<h3 class="text-xl font-bold text-brand-dark mb-4">Services ({{ $provider->services->count() }})</h3>
					<div class="space-y-3">
						@foreach($provider->services as $service)
							<div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
								<div>
									<p class="font-semibold text-brand-dark">{{ $service->name }}</p>
									<p class="text-sm text-gray-500">{{ $service->category->name ?? 'Uncategorized' }}</p>
								</div>
								<div class="text-right">
									@if($service->pivot->price_min && $service->pivot->price_max)
										<p class="font-semibold text-accent-DEFAULT">
											{{ $service->pivot->price_min }} - {{ $service->pivot->price_max }} TND
										</p>
									@endif
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif

			{{-- Action Buttons --}}
			<div class="flex flex-wrap gap-4">
				<a href="{{ route('admin.providers.edit', $provider) }}"
					class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-all">
					✏️ Edit Provider
				</a>

				@if($provider->status !== 'approved')
					<form action="{{ route('admin.providers.approve', $provider) }}" method="POST" class="inline">
						@csrf
						<button type="submit"
							class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition-all">
							✓ Approve
						</button>
					</form>
				@endif

				@if($provider->status === 'approved')
					<form action="{{ route('admin.providers.reject', $provider) }}" method="POST" class="inline">
						@csrf
						<button type="submit" onclick="return confirm('Are you sure you want to reject this provider?');"
							class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-xl transition-all">
							⚠️ Reject
						</button>
					</form>
				@endif

				<form action="{{ route('admin.providers.destroy', $provider) }}" method="POST" class="inline">
					@csrf
					@method('DELETE')
					<button type="submit"
						onclick="return confirm('Are you sure you want to delete this provider? This action cannot be undone.');"
						class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-all">
						🗑️ Delete
					</button>
				</form>
			</div>
		</div>
	</div>
@endsection