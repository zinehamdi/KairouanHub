{{-- Button component. Purpose: consistent button style. --}}
<button {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-brand text-white rounded hover:bg-brand-light focus:outline-none focus:ring']) }}>
    {{ $slot }}
</button>
