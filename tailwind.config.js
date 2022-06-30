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
                100:'#7F1B1B',
                200:'#BA5047',
                300:'#FCF0C8',
                400:'#59A9FF',
            }
        },

      }
    },
    plugins: [],
  };

