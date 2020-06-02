const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js(['resources/js/app.js', 'resources/js/perfect-scrollbar.jquery.min.js', 'resources/js/paper-dashboard.js', 'resources/js/currency.js', 'resources/js/jquery.numeric.js', 'resources/js/draggable.js', 'resources/js/EZView.js'], 'public/js/all.js')
.js('resources/js/app.js', 'public/js').sass('resources/sass/app.scss', 'public/css').sass('resources/sass/login.scss', 'public/css').version();
