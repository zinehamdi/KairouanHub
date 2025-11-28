{{-- Footer: links, language switcher, copyright --}}
<footer class="bg-white dark:bg-neutral-dark border-t border-neutral-light mt-8 py-4">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-4">
        <div class="flex space-x-4 mb-2 md:mb-0">
            <a href="{{ route('home') }}" class="text-neutral hover:text-brand">{{ __('footer.links.home') }}</a>
            <a href="{{ route('services.index') }}"
                class="text-neutral hover:text-brand">{{ __('footer.links.services') }}</a>
            <a href="{{ route('providers.index') }}"
                class="text-neutral hover:text-brand">{{ __('footer.links.providers') }}</a>
        </div>
        <div class="text-neutral text-sm">{{ __('footer.copyright', ['year' => date('Y')]) }}</div>
    </div>
</footer>