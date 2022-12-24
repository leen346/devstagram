/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    // "./resources/views/layouts/app.blade.php"
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
