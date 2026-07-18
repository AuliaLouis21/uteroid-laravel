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
                sans: ['Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif'],
            },
            colors: {
                brand: {
                    DEFAULT: '#DF282A',
                    dark: '#ba131a',
                    light: '#EBF5FE',
                },
                utero: {
                    dark: '#2A2A2A',
                    body: '#333',
                    link: '#06F',
                    linkhover: '#555',
                    border: '#CCC',
                    tablehead: '#09F',
                },
            },
            width: {
                'site': '860px',
            },
        },
    },

    plugins: [forms],
};
