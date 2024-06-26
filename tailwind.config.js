/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                nunito: ['Nunito', 'sans-serif'],
            },
            colors: {
                'dogger-orange': {
                    '50': '#fff6ed',
                    '100': '#ffead4',
                    '200': '#ffd1a8',
                    '300': '#ffb170',
                    '400': '#ff8437',
                    '500': '#ff5f0b',
                    '600': '#f04706',
                    '700': '#c73207',
                    '800': '#9e290e',
                    '900': '#7f250f',
                },
                'dogger-gray' : {
                    'dark': '#333333',
                    DEFAULT: '#666666',
                    'light': '#F5F5F5',
                }
            },
            screens: {
                xs: '480px',
            }
        },
    },
    plugins: [],
}

