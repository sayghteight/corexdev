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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gaming: {
                    dark:    '#0a0e1a',
                    darker:  '#060910',
                    card:    '#111827',
                    border:  '#1e2a3a',
                    cyan:    '#00d4ff',
                    orange:  '#ff6b00',
                    yellow:  '#ffd700',
                    purple:  '#8b5cf6',
                },
            },
        },
    },

    plugins: [forms],
};
