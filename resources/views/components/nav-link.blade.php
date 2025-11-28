@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-6 py-2.5 text-base font-bold leading-5 bg-white/20 text-white shadow-md hover:shadow-lg border-b-4 border-white transition-all duration-300 transform hover:-translate-y-0.5 backdrop-blur-sm'
            : 'inline-flex items-center px-6 py-2.5 text-base font-bold leading-5 text-white/90 hover:text-white border-b-4 border-transparent hover:border-white/50 hover:bg-white/10 transition-all duration-300 transform hover:-translate-y-0.5';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
