import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

const customColors = {
    transparent: 'transparent',
    current: 'currentColor',
    slate: colors.slate,
    green: colors.emerald,
    purple: colors.violet,
    amber: colors.amber,
    pink: colors.fuchsia,
    emerald: colors.emerald,
    indigo: colors.indigo,
    yellow: colors.yellow,
    abobora: {
        50: '#fff7ed',
        100: '#ffedd5',
        200: '#fed7aa',
        300: '#fdba74',
        400: '#fb923c',
        500: '#f97316',
        600: '#ea580c',
        700: '#c2410c',
        800: '#9a3412',
        900: '#7c2d12',
        950: '#431407',
    },
    current: 'currentColor',
    transparent: 'transparent',
    white: '#FFFFFF',
    black: '#1C2434',
    // red: '#FB5454',
    // red: colors.red,
    'black-2': '#010101',
    body: '#64748B',
    neutral: colors.gray,
    bodydark: '#AEB7C0',
    bodydark1: '#DEE4EE',
    bodydark2: '#8A99AF',
    primary: '#3C50E0',
    secondary: '#80CAEE',
    stroke: '#E2E8F0',
    gray: '#EFF4FB',
    graydark: '#333A48',
    'gray-2': '#F7F9FC',
    'gray-3': '#FAFAFA',
    whiten: '#F1F5F9',
    whiter: '#F5F7FD',
    boxdark: '#24303F',
    'boxdark-2': '#1A222C',
    strokedark: '#2E3A47',
    'form-strokedark': '#3d4d60',
    'form-input': '#1d2a39',
    'meta-1': '#DC3545',
    'meta-2': '#EFF2F7',
    'meta-3': '#10B981',
    'meta-4': '#313D4A',
    'meta-5': '#259AE6',
    'meta-6': '#FFBA00',
    'meta-7': '#FF6766',
    'meta-8': '#F0950C',
    'meta-9': '#E5E7EB',
    'meta-10': '#0FADCF',
    success: '#219653',
    danger: '#D34053',
    warning: '#FFA70B',
}

/** @type {import('tailwindcss').Config} */
export default {
    // darkMode: 'class',
    // darkMode: 'media',
    content: [
        './index.html',
        './index.php',
        './public/index.php',
        './src/**/*.{vue,js,ts,jsx,tsx}',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.{vue,js,ts,jsx,tsx}',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                satoshi: ['Satoshi', 'sans-serif']
            },
            screens: {
              '2xsm': '375px',
              xsm: '425px',
              '3xl': '2000px',
              ...defaultTheme.screens
            },
            colors: {
                ...(customColors),
                ...colors,
            },

            keyframes: {
                linspin: {
                    '100%': { transform: 'rotate(360deg)' }
                },
                easespin: {
                    '12.5%': { transform: 'rotate(135deg)' },
                    '25%': { transform: 'rotate(270deg)' },
                    '37.5%': { transform: 'rotate(405deg)' },
                    '50%': { transform: 'rotate(540deg)' },
                    '62.5%': { transform: 'rotate(675deg)' },
                    '75%': { transform: 'rotate(810deg)' },
                    '87.5%': { transform: 'rotate(945deg)' },
                    '100%': { transform: 'rotate(1080deg)' }
                },
                'left-spin': {
                    '0%': { transform: 'rotate(130deg)' },
                    '50%': { transform: 'rotate(-5deg)' },
                    '100%': { transform: 'rotate(130deg)' }
                },
                'right-spin': {
                    '0%': { transform: 'rotate(-130deg)' },
                    '50%': { transform: 'rotate(5deg)' },
                    '100%': { transform: 'rotate(-130deg)' }
                },
                rotating: {
                    '0%, 100%': { transform: 'rotate(360deg)' },
                    '50%': { transform: 'rotate(0deg)' }
                },
                topbottom: {
                    '0%, 100%': { transform: 'translate3d(0, -100%, 0)' },
                    '50%': { transform: 'translate3d(0, 0, 0)' }
                },
                bottomtop: {
                    '0%, 100%': { transform: 'translate3d(0, 0, 0)' },
                    '50%': { transform: 'translate3d(0, -100%, 0)' }
                }
            },
            animation: {
                linspin: 'linspin 1568.2353ms linear infinite',
                easespin: 'easespin 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both',
                'left-spin': 'left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both',
                'right-spin': 'right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both',
                'ping-once': 'ping 5s cubic-bezier(0, 0, 0.2, 1)',
                rotating: 'rotating 30s linear infinite',
                topbottom: 'topbottom 60s infinite alternate linear',
                bottomtop: 'bottomtop 60s infinite alternate linear',
                'spin-1.5': 'spin 1.5s linear infinite',
                'spin-2': 'spin 2s linear infinite',
                'spin-3': 'spin 3s linear infinite'
            }
        },
    },

    plugins: [
        forms,
    ],
};
