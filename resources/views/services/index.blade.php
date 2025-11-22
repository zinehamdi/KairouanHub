@extends('layouts.app')

@section('content')
    <!-- Services Hero Section -->
    <div class="relative bg-mediterranean-gradient py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h1 class="text-5xl md:text-6xl font-heading font-bold text-deep-blue mb-6">
                    خدماتنا المميزة
                </h1>
                <p class="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto">
                    نقدم لك مجموعة شاملة من الخدمات الاحترافية لجعل حياتك أسهل وأكثر راحة
                </p>
            </div>

            <!-- Search and Filter Form -->
            <div class="max-w-4xl mx-auto">
                <form method="GET" action="{{ route('services.index') }}" class="bg-white rounded-2xl shadow-soft-lg p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-terracotta" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="q" value="{{ request('q') }}"
                                    placeholder="ابحث عن الخدمة التي تحتاجها..." class="input-mediterranean pr-12" />
                            </div>
                        </div>

                        <!-- Category Select -->
                        <div>
                            <select name="category" class="input-mediterranean appearance-none">
                                <option value="">جميع الفئات 🏷️</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" @selected(request('category') === $cat->slug)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Active Only Checkbox -->
                        <div class="flex items-center">
                            <label
                                class="flex items-center gap-3 px-6 py-4 bg-soft-cream rounded-xl cursor-pointer hover:bg-gray-100 transition-all duration-300 w-full">
                                <input type="checkbox" name="active" value="1" @checked(request()->boolean('active', true))
                                    class="w-5 h-5 text-terracotta rounded focus:ring-mediterranean-blue focus:ring-2" />
                                <span class="font-bold text-deep-blue">الخدمات النشطة فقط ✓</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-terracotta w-full text-xl">
                        <span class="inline-flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            ابحث الآن
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Services Grid Section -->
    <div class="py-20 bg-soft-cream">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Services Count Badge -->
            @if($services->total() > 0)
                <div class="text-center mb-12">
                    <div
                        class="inline-block px-8 py-4 bg-terracotta-gradient text-white font-bold text-lg rounded-full shadow-soft">
                        🎯 {{ $services->total() }} خدمة متاحة
                    </div>
                </div>
            @endif

            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse($services as $service)
                    <article class="card-mediterranean overflow-hidden">
                        <!-- Service Header -->
                        <div class="relative h-40 bg-mediterranean-gradient overflow-hidden">
                            <!-- Service Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-soft">
                                    @if(str_contains(strtolower($service->name), 'سباكة') || str_contains(strtolower($service->name), 'plumb'))
                                        <svg class="w-10 h-10 text-terracotta" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 3v18m0-18a3 3 0 013 3v3h-6V6a3 3 0 013-3z" />
                                            <path d="M9 12h6v6a3 3 0 11-6 0v-6z" />
                                        </svg>
                                    @elseif(str_contains(strtolower($service->name), 'كهرباء') || str_contains(strtolower($service->name), 'electric'))
                                        <svg class="w-10 h-10 text-terracotta" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z" />
                                        </svg>
                                    @elseif(str_contains(strtolower($service->name), 'تكييف') || str_contains(strtolower($service->name), 'ac') || str_contains(strtolower($service->name), 'air'))
                                        <svg class="w-10 h-10 text-terracotta" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 2a1 1 0 011 1v1.323l3.954 1.582a1 1 0 01.641.935V14a1 1 0 01-.641.935L11 16.516V18a1 1 0 11-2 0v-1.516l-3.954-1.581A1 1 0 014 14V6.84a1 1 0 01.641-.935L8.954 4.323V3a1 1 0 011-1zM6 7.42v5.16l4 1.599V9.017L6 7.419zm8 5.16V7.42l-4-1.598v5.164l4 1.596z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @elseif(str_contains(strtolower($service->name), 'نقل') || str_contains(strtolower($service->name), 'moving'))
                                        <svg class="w-10 h10 text-terracotta" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            <path
                                                d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                        </svg>
                                    @else
                                        <svg class="w-10 h-10 text-terracotta" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="badge-terracotta">
                                    {{ $service->category->name ?? 'خدمة عامة' }}
                                </span>
                            </div>
                        </div>

                        <!-- Service Content -->
                        <div class="p-6">
                            <h3
                                class="text-xl font-bold text-deep-blue mb-3 hover:text-terracotta transition-colors duration-300">
                                {{ e($service->name) }}
                            </h3>
                            <p class="text-gray-600 mb-6 leading-relaxed line-clamp-3 text-sm">
                                {{ e(\Illuminate\Support\Str::limit($service->summary, 120)) }}
                            </p>

                            <!-- Action Button -->
                            <a href="{{ route('services.show', $service->slug) }}"
                                class="btn-mediterranean w-full justify-center inline-flex items-center gap-2">
                                اكتشف المزيد
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-20">
                        <div class="inline-block p-8 bg-white rounded-2xl shadow-soft">
                            <div class="w-24 h-24 mx-auto mb-6 bg-soft-cream rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-deep-blue mb-4">لا توجد خدمات متاحة</h3>
                            <p class="text-gray-600 text-lg mb-6">جرب تغيير معايير البحث أو تصفح جميع الخدمات</p>
                            <a href="{{ route('services.index') }}" class="btn-terracotta inline-block">
                                عرض جميع الخدمات
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($services->hasPages())
                <div class="mt-12">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="py-20 bg-blue-gradient">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                لم تجد ما تبحث عنه؟
            </h2>
            <p class="text-xl text-white/95 mb-8 max-w-2xl mx-auto">
                تواصل معنا مباشرة وسنساعدك في إيجاد الخدمة المثالية لاحتيا جاتك
            </p>
            <a href="{{ route('home') }}"
                class="px-12 py-5 bg-white text-mediterranean-blue font-bold text-xl rounded-xl shadow-2xl hover:shadow-soft-lg hover:scale-105 transition-all duration-300 inline-block">
                تواصل معنا الآن
            </a>
        </div>
    </div>
@endsection