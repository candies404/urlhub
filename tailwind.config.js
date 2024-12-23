import forms from '@tailwindcss/forms';
import presetPowerGrid from './vendor/power-components/livewire-powergrid/tailwind.config.js';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./app/Livewire/**/*Table.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/filament/**/*.blade.php",
        "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
        "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php",
    ],
    presets: [
        presetPowerGrid,
    ],
    theme: {
        extend: {
            colors: {
                "primary-50": "#eef2ff",
                "primary-100": "#e0e7ff",
                "primary-500": "#6366f1",
                "primary-700": "#4338ca",
                "primary-800": "#3730a3",
                "uh-blue": "#3d5b99",
                "uh-border-color": "#d0d7de",
            },
        },
    },
    plugins: [
        // forms({strategy: 'class'})
        forms
    ],
};
