import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {

    // Blade and JS content paths for Tailwind JIT
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],


    theme: {
        extend: {
            fontFamily: {
                sans: ['Tajawal', 'system-ui', ...defaultTheme.fontFamily.sans],
                serif: ['Amiri', 'Georgia', ...defaultTheme.fontFamily.serif],
                arabic: ['Amiri', 'Tajawal'],
            },
            colors: {
                // Mediterranean Color Palette
                mediterranean: {
                    terracotta: '#E07A5F',
                    blue: '#3D5A80',
                    sand: '#F4A261',
                    'deep-blue': '#264653',
                    'light-blue': '#81B9D4',
                    cream: '#F2F3F4',
                },
                brand: {
                    DEFAULT: '#264653',    // Deep Blue
                    light: '#F2F3F4',      // Soft Cream
                    dark: '#264653',       // Deep Blue
                },
                accent: {
                    DEFAULT: '#E07A5F',    // Terracotta
                    sand: '#F4A261',       // Warm Sand
                    blue: '#3D5A80',       // Mediterranean Blue
                },
            },
            backgroundImage: {
                'kairouan-pattern': "url('/images/kairouan-background.jpg')",
                'geometric-pattern': "url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v6h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\")",
                'mosque-arch': "radial-gradient(ellipse at top, transparent 60%, rgba(212, 175, 55, 0.1) 100%)",
            },
            boxShadow: {
                'kairouan': '0 4px 6px -1px rgba(107, 62, 38, 0.1), 0 2px 4px -1px rgba(107, 62, 38, 0.06)',
                'gold': '0 0 20px rgba(212, 175, 55, 0.3)',
                'inset-gold': 'inset 0 0 20px rgba(212, 175, 55, 0.2)',
                'brass': '0 4px 12px rgba(184, 115, 51, 0.25)',
            },
            borderRadius: {
                'arch': '50% 50% 0 0',
                'kairouan': '0.5rem',
            },
            animation: {
                'shimmer': 'shimmer 2s linear infinite',
                'fade-in': 'fadeIn 0.5s ease-in',
                'slide-up': 'slideUp 0.5s ease-out',
            },
            keyframes: {
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
        },
    },

    plugins: [forms],
};
