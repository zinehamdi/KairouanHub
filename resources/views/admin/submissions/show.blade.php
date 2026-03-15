@extends('layouts.admin')

@section('admin-content')
	<div class="py-8 px-4 sm:px-6 lg:px-8">
		<div class="max-w-4xl mx-auto">
			<!-- Header -->
			<div class="mb-8">
				<div class="flex items-center gap-4 mb-4">
					<a href="{{ route('admin.submissions.index', ['status' => 'pending']) }}"
						class="text-white bg-gradient-to-r from-[#E07A5F] to-[#F4A261] hover:from-[#F4A261] hover:to-[#E07A5F] p-2 rounded-lg transition-all">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M10 19l-7-7m0 0l7-7m-7 7h18" />
						</svg>
					</a>
					<div>
						<h1 class="text-3xl font-bold text-brand-dark">Review Submission</h1>
						<p class="text-gray-600 mt-1">مراجعة اقتراح مزود الخدمة</p>
					</div>
				</div>
			</div>

			<!-- Status Badge -->
			<div class="mb-6">
				<span
					class="px-4 py-2 text-sm font-semibold rounded-full 
					{{ $submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
		($submission->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
					Status: {{ ucfirst($submission->status) }}
				</span>
				<span class="ml-4 text-gray-500">Submitted {{ $submission->created_at->diffForHumans() }} by
					{{ $submission->user->name ?? 'Unknown' }}</span>
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

			<!-- Editable Form -->
			<div class="bg-white rounded-2xl shadow-lg p-8">
				<form action="{{ route('admin.submissions.update', $submission) }}" method="POST">
					@csrf
					@method('PUT')

					<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
						<!-- Provider Name -->
						<div>
							<label class="block text-sm font-semibold text-brand-dark mb-2">Provider Name *</label>
							<input type="text" name="provider_name"
								value="{{ old('provider_name', $submission->provider_name) }}" required
								class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all"
								{{ $submission->status !== 'pending' ? 'disabled' : '' }}>
							@error('provider_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
						</div>

						<!-- Phone -->
						<div>
							<label class="block text-sm font-semibold text-brand-dark mb-2">Phone *</label>
							<input type="tel" name="phone" value="{{ old('phone', $submission->phone) }}" required
								class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all"
								{{ $submission->status !== 'pending' ? 'disabled' : '' }}>
							@error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
						</div>

						<!-- Category -->
						<div>
							<label class="block text-sm font-semibold text-brand-dark mb-2">Category *</label>
							<select name="category_id" required
								class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all"
								{{ $submission->status !== 'pending' ? 'disabled' : '' }}>
								@foreach($categories as $category)
									<option value="{{ $category->id }}" {{ $submission->category_id == $category->id ? 'selected' : '' }}>
										{{ $category->name }} {{ $category->name_ar ? "({$category->name_ar})" : '' }}
									</option>
								@endforeach
							</select>
							@error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
						</div>

						<!-- City -->
						<div>
							<label class="block text-sm font-semibold text-brand-dark mb-2">City</label>
							<input type="text" name="city" value="{{ old('city', $submission->city ?? 'Kairouan') }}"
								class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all"
								{{ $submission->status !== 'pending' ? 'disabled' : '' }}>
						</div>
					</div>

					<!-- Description -->
					<div class="mb-6">
						<label class="block text-sm font-semibold text-brand-dark mb-2">Description</label>
						<textarea name="description" rows="4"
							class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all"
							{{ $submission->status !== 'pending' ? 'disabled' : '' }}>{{ old('description', $submission->description) }}</textarea>
					</div>

					@if($submission->status === 'pending')
						<!-- Save Changes Button -->
						<div class="mb-6">
							<button type="submit"
								class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-all">
								💾 Save Changes
							</button>
						</div>
					@endif
				</form>

				@if($submission->status === 'pending')
					<hr class="my-8 border-gray-200">

					<!-- Action Buttons -->
					<div class="flex flex-wrap gap-4">
						<!-- Approve Button -->
						<form action="{{ route('admin.submissions.approve', $submission) }}" method="POST">
							@csrf
							<button type="submit"
								onclick="return confirm('Approve this provider suggestion with the current details?');"
								class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
								✅ Approve & Create Provider
							</button>
						</form>

						<!-- Reject Button -->
						<button onclick="document.getElementById('rejectSection').classList.toggle('hidden')"
							class="px-8 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
							❌ Reject
						</button>
					</div>

					<!-- Reject Section (Hidden by default) -->
					<div id="rejectSection" class="hidden mt-6 p-6 bg-red-50 rounded-xl">
						<form action="{{ route('admin.submissions.reject', $submission) }}" method="POST">
							@csrf
							<label class="block text-sm font-semibold text-red-800 mb-2">Rejection Reason *</label>
							<textarea name="reason" required rows="3"
								class="w-full px-4 py-3 border-2 border-red-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all"
								placeholder="Please provide a reason for rejecting this suggestion..."></textarea>
							<button type="submit"
								class="mt-4 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all">
								Confirm Rejection
							</button>
						</form>
					</div>
				@else
					<!-- Already Reviewed -->
					<div class="mt-6 p-4 bg-gray-100 rounded-xl">
						<p class="text-gray-600">
							This submission was {{ $submission->status }} by {{ $submission->reviewer->name ?? 'Unknown' }}
							on {{ $submission->reviewed_at?->format('M d, Y H:i') ?? 'N/A' }}.
						</p>
						@if($submission->rejection_reason)
							<p class="mt-2 text-red-600"><strong>Reason:</strong> {{ $submission->rejection_reason }}</p>
						@endif
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection