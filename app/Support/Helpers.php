<?php
// i18n helpers, meta tags builder stubs

if (!function_exists('supported_locales')) {
    /**
     * Get supported locales.
     * @return array
     */
    function supported_locales(): array
    {
        // اللغات المدعومة
        return ['ar', 'fr', 'en'];
    }
}

if (!function_exists('meta_tags')) {
    /**
     * Build meta tags for a page.
     * @param string $title
     * @param string $description
     * @return array
     */
    function meta_tags(string $title, string $description = ''): array
    {
        // بناء وسوم الميتا
        return [
            'title' => $title,
            'description' => $description,
        ];
    }
}
