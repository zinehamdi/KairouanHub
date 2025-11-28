@extends('layouts.app')

@section('content')
	<div class="min-h-screen bg-kairouan-warm-cream py-12">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<!-- Header -->
			<div class="mb-8">
				<h1 class="text-4xl font-bold text-brand-dark mb-2">Admin Dashboard</h1>
				<p class="text-gray-600">لوحة تحكم المشرف - إدارة المنصة</p>
			</div>

			<!-- Stats Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
				<!-- Total Users -->
				<div class="card-mediterranean p-6">
					<div class="flex items-center justify-between">
						<div>
							<p class="text-gray-600 text-sm font-medium">إجمالي المستخدمين</p>
							<p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_users }}</p>
						</div>
				<div class="w-16 h-16 rounded-full flex items-center justify-center"
					 style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
					<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
							</svg>
						</div>
					</div>
				</div>

				<!-- Total Providers -->
				<div class="card-mediterranean p-6">
					<div class="flex items-center justify-between">
						<div>
							<p class="text-gray-600 text-sm font-medium">مقدمو الخدمات</p>
							<p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_providers }}</p>
						</div>
				<div class="w-16 h-16 rounded-full flex items-center justify-center"
					 style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
					<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
							</svg>
						</div>
					</div>
				</div>

				<!-- Total Services -->
				<div class="card-mediterranean p-6">
					<div class="flex items-center justify-between">
						<div>
							<p class="text-gray-600 text-sm font-medium">إجمالي الخدمات</p>
							<p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_services }}</p>
						</div>
				<div class="w-16 h-16 rounded-full flex items-center justify-center"
					 style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
					<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
							</svg>
						</div>
					</div>
				</div>

				<!-- Total Categories -->
				<div class="card-mediterranean p-6">
					<div class="flex items-center justify-between">
						<div>
							<p class="text-gray-600 text-sm font-medium">الفئات</p>
							<p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_categories }}</p>
						</div>
				<div class="w-16 h-16 rounded-full flex items-center justify-center"
					 style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
					<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
							</svg>
						</div>
					</div>
				</div>

				<!-- Total Requests -->
				<div class="card-mediterranean p-6">
					<div class="flex items-center justify-between">
						<div>
							<p class="text-gray-600 text-sm font-medium">إجمالي الطلبات</p>
							<p class="text-3xl font-bold text-brand-dark mt-2">{{ $total_requests }}</p>
						</div>
				<div class="w-16 h-16 rounded-full flex items-center justify-center"
					 style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
					<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
							</svg>
						</div>
					</div>
				</div>

				<!-- Pending Requests -->
				<div class="card-mediterranean p-6">
					<div class="flex items-center justify-between">
						<div>
							<p class="text-gray-600 text-sm font-medium">طلبات قيد الانتظار</p>
							<p class="text-3xl font-bold mt-2" style="color: #E07A5F;">{{ $pending_requests }}</p>
						</div>
						<div class="w-16 h-16 bg-blue-gradient rounded-full flex items-center justify-center">
							<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
							</svg>
						</div>
					</div>
				</div>
			</div>

			<!-- Quick Actions -->
			<div class="mb-8">
				<h2 class="text-2xl font-bold text-brand-dark mb-4">إجراءات سريعة</h2>
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
					<a href="{{ route('admin.categories.index') }}" class="btn-mediterranean text-center">
						إدارة الفئات
					</a>
					<a href="{{ route('admin.services.index') }}" class="btn-terracotta text-center">
						إدارة الخدمات
					</a>
					<a href="{{ route('admin.providers.index') }}" class="btn-terracotta text-center">
						إدارة مزودي الخدمات
					</a>
					<a href="{{ route('services.index') }}" class="btn-outline-mediterranean text-center">
						عرض الخدمات
					</a>
				</div>
			</div>

			<!-- Recent Activity -->
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
				<!-- Recent Users -->
				<div class="card-mediterranean p-6">
					<h3 class="text-xl font-bold text-brand-dark mb-4">آخر المستخدمين</h3>
					<div class="space-y-3">
						@forelse($recent_users as $user)
							<div class="flex items-center justify-between p-3 bg-kairouan-warm-cream rounded-lg">
								<div class="flex items-center gap-3">
								<div class="w-10 h-10 rounded-full flex items-center justify-center"
									 style="background: linear-gradient(135deg, #E07A5F 0%, #F4A261 100%);">
									<span class="text-white font-bold">{{ substr($user->name, 0, 1) }}</span>
								</div>
									<div>
										<p class="font-semibold text-brand-dark">{{ $user->name }}</p>
										<p class="text-sm text-gray-600">{{ $user->email }}</p>
									</div>
								</div>
								<span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
							</div>
						@empty
							<p class="text-gray-500 text-center py-4">لا توجد بيانات</p>
						@endforelse
					</div>
				</div>

				<!-- Recent Requests -->
				<div class="card-mediterranean p-6">
					<h3 class="text-xl font-bold text-brand-dark mb-4">آخر الطلبات</h3>
					<div class="space-y-3">
						@forelse($recent_requests as $request)
							<div class="p-3 bg-kairouan-warm-cream rounded-lg">
								<div class="flex items-center justify-between mb-2">
									<p class="font-semibold text-brand-dark">{{ $request->user->name }}</p>
									<span class="badge-{{ $request->status === 'pending' ? 'terracotta' : 'blue' }}">
										{{ ucfirst($request->status) }}
									</span>
								</div>
								<p class="text-sm text-gray-600">{{ $request->service->name ?? 'N/A' }}</p>
								<p class="text-xs text-gray-500 mt-1">{{ $request->created_at->diffForHumans() }}</p>
							</div>
						@empty
							<p class="text-gray-500 text-center py-4">لا توجد طلبات</p>
						@endforelse
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection