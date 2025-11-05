@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-5 py-3 rounded-full text-lg font-bold leading-5 bg-gradient-to-r from-accent-DEFAULT to-accent-amber text-white shadow-lg hover:shadow-gold transition-all duration-300'
            : 'inline-flex items-center px-5 py-3 rounded-full text-lg font-bold leading-5 text-gray-900 hover:bg-accent-DEFAULT/10 hover:text-accent-DEFAULT transition-all duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
