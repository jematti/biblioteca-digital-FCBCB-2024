module.exports = {
    content: [

      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
    ],
    theme: {
      extend: {
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

      }
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
    ],
  };

