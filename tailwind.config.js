import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: '#ce181e',
                    dark: '#a01418',
                    light: '#d52f25',
                    50: '#FEF2F2',
                    100: '#FDE8E8',
                    200: '#F9B4B4',
                    500: '#ce181e',
                    600: '#b8161b',
                    700: '#a01418',
                    800: '#8a1115',
                    900: '#730e11',
                },
                gold: {
                    DEFAULT: '#D4AF37',
                    light: '#E8CC6E',
                    dark: '#B8941E',
                },
                utero: {
                    dark: '#000000',
                    body: '#111111',
                    muted: '#6B7280',
                    link: '#ce181e',
                    linkhover: '#FFFFFF',
                    border: '#E5E7EB',
                    surface: '#FFFFFF',
                    bg: '#F3F4F6',
                },
            },
            maxWidth: {
                'site': '1320px',
            },
            borderRadius: {
                'card': '12px',
            },
            boxShadow: {
                'card': '0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06)',
                'card-hover': '0 10px 25px rgba(0,0,0,0.1), 0 4px 10px rgba(0,0,0,0.06)',
                'nav': '0 2px 8px rgba(0,0,0,0.15)',
            },
        },
    },

    plugins: [forms],
};
