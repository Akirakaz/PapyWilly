const colorPalette = require('./assets/js/colorPalette')

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
            },
            maxWidth: {
                'screen-fhd': '1920px',
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
            }
        },
        fontFamily: {
            sans: ['"Rajdhani", sans-serif'],
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
    ],
};


