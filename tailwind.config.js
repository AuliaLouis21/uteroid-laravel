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
                    DEFAULT: '#8B0000',
                    dark: '#6B0000',
                    light: '#A52A2A',
                    50: '#FEF2F2',
                    100: '#FDE8E8',
                    200: '#F9B4B4',
                    500: '#8B0000',
                    600: '#7A0000',
                    700: '#6B0000',
                    800: '#5C0000',
                    900: '#4D0000',
                },
                gold: {
                    DEFAULT: '#D4AF37',
                    light: '#E8CC6E',
                    dark: '#B8941E',
                },
                utero: {
                    dark: '#1A1A2E',
                    body: '#2D2D3A',
                    muted: '#6B7280',
                    link: '#8B0000',
                    linkhover: '#D4AF37',
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
