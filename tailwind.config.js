import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#ebeff3',
                    100: '#d6dfe7',
                    200: '#adbecf',
                    300: '#849eb8',
                    400: '#5b7da0',
                    500: '#325d88',
                    600: '#5b7da0',
                    700: '#386999',
                    800: '#325d88',
                    900: '#264666',
                    950: '#192f44',
                },
                secondary: '#8e8c84',
                success: '#93c54b',
                info: '#29abe0',
                warning: '#f47c3c',
                danger: '#d9534f',
                light: '#f8f5f0',
            },
        },
    },

    plugins: [forms, typography],
};
