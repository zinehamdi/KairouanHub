@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-gradient-to-b from-kairouan-limestone/30 to-white py-8">
		<div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-2xl">

			{{-- Header --}}
			<div class="text-center mb-8">
				<div
					class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-violet-500 to-purple-500 mb-4 shadow-lg">
					<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
					</svg>
				</div>
				<h1 class="text-3xl font-bold text-brand-dark mb-2">
					{{ __('wizard.suggest.title') }}
				</h1>
				<p class="text-gray-600">
					{{ __('wizard.suggest.intro') }}
				</p>
			</div>

			{{-- Form Card --}}
			<div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
				<form action="{{ route('providers.suggest.store') }}" method="POST" class="space-y-6">
					@csrf

					{{-- Provider Name --}}
					<div>
						<label for="provider_name" class="block text-sm font-bold text-brand-dark mb-2">
							{{ __('wizard.suggest.provider_name') }} *
						</label>
						<input type="text" id="provider_name" name="provider_name" value="{{ old('provider_name') }}"
							class="input-mediterranean w-full" placeholder="{{ __('wizard.suggest.step1_desc') }}" required>
						@error('provider_name')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Phone --}}
					<div>
						<label for="phone" class="block text-sm font-bold text-brand-dark mb-2">
							{{ __('wizard.suggest.phone') }} *
						</label>
						<input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
							class="input-mediterranean w-full" placeholder="{{ __('wizard.suggest.step2_desc') }}" dir="ltr"
							required>
						@error('phone')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Category --}}
					<div>
						<label for="category_id" class="block text-sm font-bold text-brand-dark mb-2">
							{{ __('wizard.suggest.category') }}
						</label>
						<select id="category_id" name="category_id" class="input-mediterranean w-full">
							<option value="">{{ __('wizard.suggest.step3_desc') }}</option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
									{{ $category->localized_name ?? $category->name }}
								</option>
							@endforeach
						</select>
						@error('category_id')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- City --}}
					<div>
						<label for="city" class="block text-sm font-bold text-brand-dark mb-2">
							{{ __('wizard.suggest.city') }}
						</label>
						<input type="text" id="city" name="city" value="{{ old('city') }}"
							class="input-mediterranean w-full" placeholder="{{ __('wizard.suggest.step4_desc') }}">
						@error('city')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Notes --}}
					<div>
						<label for="description" class="block text-sm font-bold text-brand-dark mb-2">
							{{ __('wizard.suggest.notes') }}
						</label>
						<textarea id="description" name="description" rows="3"
							class="input-mediterranean w-full resize-none"
							maxlength="500">{{ old('description') }}</textarea>
						@error('description')
							<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Trust Points Preview --}}
					<div class="bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl p-4 border border-violet-100">
						<div class="flex items-center gap-3">
							<div class="w-10 h-10 rounded-full bg-violet-500 flex items-center justify-center">
								<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
									<path
										d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
								</svg>
							</div>
							<div>
								<p class="font-bold text-violet-700">
									{{ __('wizard.suggest.points_message', ['points' => 50]) }}
								</p>
							</div>
						</div>
					</div>

					{{-- Actions --}}
					<div class="flex flex-col sm:flex-row gap-3 pt-4">
						<button type="submit" class="btn-mediterranean flex-1 justify-center py-4 text-lg">
							{{ __('wizard.suggest.submit') }}
						</button>
						<a href="{{ url()->previous() }}"
							class="btn-outline-mediterranean flex-shrink-0 justify-center py-4">
							{{ __('wizard.cancel') }}
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection