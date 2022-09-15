const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],

    theme: {
        extend: {
            // fontFamily: {
            //     sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            // },
            colors:{
                custom:{
                    100:'#090D2A',
                    200:'#4F284F',
                    300:'#9A4461',
                    400:'#D87060',
                    500:'#FAAF5A',
                    600:'#F9F871',
                }
            },
            height: {
                '128': '32rem',
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
    ],
};
