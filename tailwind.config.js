import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {    
    content: [
        './vendor/wire-elements/modal/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './resources/views/*.blade.php',
    ],
    
    safelist: [
      {
        pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
        variants: ['sm', 'md', 'lg', 'xl', '2xl']
      }
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },  
    
    plugins: [
        forms,
        require('daisyui'),
    ],
};
