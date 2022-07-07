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
                200:'#BA5047',
                300:'#FCF0C8',
                400:'#59A9FF',
                500:'#A07760'
            }
        },

      }
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
    ],
  };

