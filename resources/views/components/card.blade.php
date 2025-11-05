{{-- Card component. Purpose: display content in a styled box. --}}
<div {{ $attributes->merge(['class' => 'bg-white dark:bg-neutral-dark rounded-lg shadow p-6']) }}>
    {{ $slot }}
</div>
