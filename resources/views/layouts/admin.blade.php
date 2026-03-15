@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-kairouan-warm-cream flex">
		{{-- Sidebar --}}
		<aside
			class="hidden lg:flex lg:flex-col lg:w-64 bg-gradient-to-b from-brand-dark to-deep-blue text-white fixed h-full"
			x-data="{ open: true }">
			{{-- Logo --}}
			<div class="p-6 border-b border-white/20">
				<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
					<img src="{{ asset('images/kairouanhubLogo.PNG') }}" alt="Logo" class="h-10 w-auto">
					<span class="font-bold text-lg">Admin</span>
				</a>
			</div>

			{{-- Navigation --}}
			<nav class="flex-1 p-4 space-y-2 overflow-y-auto">
				{{-- Dashboard --}}
				<a href="{{ route('admin.dashboard') }}"
					class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' }}">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
					</svg>
					<span>{{ __('admin.dashboard', ['default' => 'لوحة التحكم']) }}</span>
				</a>

				{{-- Providers --}}
				<div x-data="{ expanded: {{ request()->routeIs('admin.providers.*') ? 'true' : 'false' }} }">
					<button @click="expanded = !expanded"
						class="flex items-center justify-between w-full px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.providers.*') ? 'bg-white/20' : 'hover:bg-white/10' }}">
						<div class="flex items-center gap-3">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
							</svg>
							<span>{{ __('admin.providers', ['default' => 'المزودين']) }}</span>
						</div>
						<svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': expanded }" fill="none"
							stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
						</svg>
					</button>
					<div x-show="expanded" x-collapse class="mt-1 ml-4 space-y-1">
						<a href="{{ route('admin.providers.index') }}"
							class="block px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.providers.index') ? 'bg-white/10' : 'hover:bg-white/5' }}">
							📋 {{ __('admin.all_providers', ['default' => 'كل المزودين']) }}
						</a>
						<a href="{{ route('admin.providers.create') }}"
							class="block px-4 py-2 rounded-lg text-sm hover:bg-white/5">
							➕ {{ __('admin.add_provider', ['default' => 'إضافة يدوية']) }}
						</a>
						<a href="{{ route('admin.providers.map-import') }}"
							class="block px-4 py-2 rounded-lg text-sm hover:bg-white/5">
							🗺️ {{ __('admin.map_import', ['default' => 'إضافة من الخريطة']) }}
						</a>
					</div>
				</div>

				{{-- Submissions --}}
				<a href="{{ route('admin.submissions.index') }}"
					class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.submissions.*') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' }}">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
					</svg>
					<span>{{ __('admin.submissions', ['default' => 'الاقتراحات']) }}</span>
					@if(isset($pending_submissions) && $pending_submissions > 0)
						<span class="bg-red-500 text-xs px-2 py-0.5 rounded-full">{{ $pending_submissions }}</span>
					@endif
				</a>

				{{-- Services --}}
				<a href="{{ route('admin.services.index') }}"
					class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.services.*') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' }}">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
					</svg>
					<span>{{ __('admin.services', ['default' => 'الخدمات']) }}</span>
				</a>

				{{-- Categories --}}
				<a href="{{ route('admin.categories.index') }}"
					class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' }}">
					<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
					</svg>
					<span>{{ __('admin.categories', ['default' => 'الفئات']) }}</span>
				</a>
			</nav>

			{{-- User Info --}}
			<div class="p-4 border-t border-white/20">
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center font-bold">
						{{ substr(auth()->user()->name, 0, 1) }}
					</div>
					<div class="flex-1 min-w-0">
						<p class="font-medium truncate">{{ auth()->user()->name }}</p>
						<p class="text-xs text-white/60">
							{{ auth()->user()->hasRole('superadmin') ? 'Superadmin' : 'Admin' }}</p>
					</div>
				</div>
			</div>
		</aside>

		{{-- Mobile Header --}}
		<div
			class="lg:hidden fixed top-0 left-0 right-0 bg-brand-dark text-white z-50 px-4 py-3 flex items-center justify-between">
			<a href="{{ route('admin.dashboard') }}" class="font-bold">Admin Panel</a>
			<button x-data @click="$dispatch('toggle-mobile-menu')" class="p-2">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
				</svg>
			</button>
		</div>

		{{-- Main Content --}}
		<main class="flex-1 lg:ml-64">
			<div class="pt-4 lg:pt-0">
				@yield('admin-content')
			</div>
		</main>
	</div>
@endsection