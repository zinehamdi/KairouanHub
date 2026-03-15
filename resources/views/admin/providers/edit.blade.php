@extends('layouts.admin')

@section('admin-content')
	<div class="py-8 px-4 sm:px-6 lg:px-8">
		<div class="max-w-4xl mx-auto">
			<!-- Header -->
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
						<h1 class="text-3xl font-bold text-brand-dark">Edit Provider</h1>
						<p class="text-gray-600 mt-1">تعديل مزود الخدمة - {{ $provider->user->name }}</p>
					</div>
				</div>
			</div>

			<!-- MAIN UPDATE FORM -->
			<div class="bg-white rounded-2xl shadow-lg p-8">
				<form action="{{ route('admin.providers.update', $provider) }}" method="POST"
					x-data="{ selectedServices: {{ json_encode($provider->services->pluck('id')->toArray()) }} }">
					@csrf
					@method('PUT')

					<!-- User Information -->
					<div class="mb-8">
						<h3 class="text-xl font-bold text-brand-dark mb-4 flex items-center gap-2">
							<svg class="w-6 h-6" style="color: #E07A5F;" fill="none" stroke="currentColor"
								viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
							</svg>
							User Information
						</h3>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<div>
								<label class="block text-sm font-semibold text-brand-dark mb-2">Full Name *</label>
								<input type="text" name="name" value="{{ old('name', $provider->user->name) }}" required
									class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
								@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
							</div>

							<div>
								<label class="block text-sm font-semibold text-brand-dark mb-2">Email *</label>
								<input type="email" name="email" value="{{ old('email', $provider->user->email) }}" required
									class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
								@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
							</div>

							<div>
								<label class="block text-sm font-semibold text-brand-dark mb-2">New Password (leave blank to
									keep)</label>
								<input type="password" name="password"
									class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
							</div>

							<div>
								<label class="block text-sm font-semibold text-brand-dark mb-2">Confirm Password</label>
								<input type="password" name="password_confirmation"
									class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
							</div>

							<div>
								<label class="block text-sm font-semibold text-brand-dark mb-2">Phone *</label>
								<input type="tel" name="phone" value="{{ old('phone', $provider->phone) }}" required
									class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
								@error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
							</div>

							<div>
								<label class="block text-sm font-semibold text-brand-dark mb-2">City</label>
								<input type="text" name="city" value="{{ old('city', $provider->city ?? 'Kairouan') }}"
									class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
							</div>
						</div>

						<div class="mt-6">
							<label class="block text-sm font-semibold text-brand-dark mb-2">Address</label>
							<input type="text" name="address" value="{{ old('address', $provider->address) }}"
								class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">
						</div>

						<div class="mt-6">
							<label class="block text-sm font-semibold text-brand-dark mb-2">Bio</label>
							<textarea name="bio" rows="3"
								class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-accent-DEFAULT focus:ring-2 focus:ring-accent-DEFAULT/20 transition-all">{{ old('bio', $provider->bio) }}</textarea>
						</div>

						<!-- Status -->
						<div class="mt-6">
							<label class="flex items-center gap-3 cursor-pointer">
								<input type="checkbox" name="is_approved" value="1" {{ $provider->is_approved ? 'checked' : '' }} class="w-5 h-5 rounded focus:ring-[#E07A5F]" style="color: #E07A5F;">
								<span class="font-semibold text-brand-dark">Approved Provider</span>
							</label>
						</div>
					</div>

					<!-- Services -->
					<div class="mb-8">
						<h3 class="text-xl font-bold text-brand-dark mb-4 flex items-center gap-2">
							<svg class="w-6 h-6" style="color: #E07A5F;" fill="none" stroke="currentColor"
								viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
							</svg>
							Services Offered *
						</h3>
						@error('services')<p class="mb-4 text-sm text-red-600">{{ $message }}</p>@enderror

						@foreach($services as $categoryName => $categoryServices)
							<div class="mb-6">
								<h4 class="font-bold text-brand-dark mb-3 text-lg">{{ $categoryName }} <span
										class="text-sm font-normal text-gray-500">({{ $categoryServices->count() }}
										services)</span></h4>
								<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
									@foreach($categoryServices as $service)
										<label
											class="relative flex items-start p-3 border-2 border-gray-200 rounded-xl hover:border-[#E07A5F] transition-all cursor-pointer"
											:class="selectedServices.includes({{ $service->id }}) ? 'border-[#E07A5F] bg-[#E07A5F]/5' : ''">
											<input type="checkbox" name="services[]" value="{{ $service->id }}" {{ $provider->services->contains($service->id) ? 'checked' : '' }}
												@change="$event.target.checked ? selectedServices.push({{ $service->id }}) : selectedServices = selectedServices.filter(id => id !== {{ $service->id }})"
												class="mt-1 h-5 w-5 rounded focus:ring-[#E07A5F]" style="color: #E07A5F;">
											<div class="ml-3 flex-1">
												<p class="font-semibold text-brand-dark text-sm">{{ $service->name }}</p>
												@if($service->name_ar)
												<p class="text-xs text-gray-500">{{ $service->name_ar }}</p>@endif
											</div>
										</label>
									@endforeach
								</div>
							</div>
						@endforeach
					</div>

					<!-- Submit Button for UPDATE -->
					<div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
						<a href="{{ route('admin.providers.index') }}"
							class="px-6 py-3 border-2 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all"
							style="border-color: #E07A5F;">
							Cancel
						</a>
						<button type="submit"
							class="px-8 py-3 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:scale-105"
							style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
							💾 Update Provider
						</button>
					</div>
				</form>
			</div>

			<!-- DELETE FORM - SEPARATE from update form! -->
			<div class="mt-6 bg-red-50 rounded-xl p-4">
				<h4 class="text-red-800 font-bold mb-2">Danger Zone</h4>
				<form action="{{ route('admin.providers.destroy', $provider) }}" method="POST"
					onsubmit="return confirm('Are you sure you want to delete this provider? This action cannot be undone.');">
					@csrf
					@method('DELETE')
					<button type="submit"
						class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-all">
						🗑️ Delete Provider
					</button>
				</form>
			</div>
		</div>
	</div>
@endsection