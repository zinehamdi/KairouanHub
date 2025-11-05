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
                // Kairouan Heritage Palette - LIGHTER & MORE READABLE
                kairouan: {
                    beige: '#F5F1E8',      // Lighter limestone
                    brown: '#8B6647',      // Softer brown
                    gold: '#D4AF37',       // Keep gold
                    amber: '#E28E0C',      // Keep amber
                    black: '#2D2621',      // Softer black
                    limestone: '#FAF8F3',  // Very light cream
                    terracotta: '#D4735C', // Softer terracotta
                    sandstone: '#E8DCC0',  // Light sand
                    copper: '#C89160',     // Lighter copper
                    olive: '#A08970',      // Lighter olive
                },
                brand: {
                    DEFAULT: '#8B6647',    // Softer Kairouan Brown
                    light: '#F5F1E8',      // Light Beige
                    dark: '#2D2621',       // Softer Deep Black
                },
                accent: {
                    DEFAULT: '#D4AF37',    // Gold
                    amber: '#E28E0C',      // Amber/Orange
                    copper: '#C89160',     // Lighter copper
                },
                neutral: {
                    DEFAULT: '#A08970',    // Lighter Olive
                    light: '#FAF8F3',      // Very light
                    dark: '#8B6647',       // Softer Brown
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
