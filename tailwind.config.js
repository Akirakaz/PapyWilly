const colorPalette = require('./assets/js/colorPalette')
const plugin = require("tailwindcss/plugin");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./templates/**/*.{twig,html.twig}",
        "./assets/js/**/*.{js,jsx,ts,tsx,vue}",
    ],
    theme: {
        extend: {
            colors: {
                'mirage': colorPalette["mirage"],
                'coral-red': colorPalette["coral-red"],
            },
            zIndex: {
                1: "1",
                2: "2",
                3: "3",
                4: "4",
                5: "5",
            },
            fontFamily: {
                rajdhani: ['Rajdhani, sans-serif'],
                papywilly: ['PapyWilly, sans-serif'],
            },
            maxWidth: {
                'screen-fhd': '120rem',
                'screen-qhd': '160rem',
            },
            padding: {
                '26': '6.5rem',
            },
            margin: {
                '26': '6.5rem',
            },
            backdropBlur: {
                xs: '2px',
            },
            fontSize: {
                '8xlc': ['6rem', '4.5rem'],
                '9xlc': ['8rem', '6rem'],
                '10xlc': ['10.625rem', '8rem'],
            },
            textShadow: {
                sm: '0 1px 2px var(--tw-shadow-color)',
                DEFAULT: '0 2px 4px var(--tw-shadow-color)',
                lg: '0 8px 16px var(--tw-shadow-color)',
            }
        },
        fontFamily: {
            sans: ['"Rajdhani", sans-serif'],
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        plugin(function({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'text-shadow': (value) => ({
                        textShadow: value
                    }),
                },
                { values: theme('textShadow') }
            )
        }),
    ],
};


