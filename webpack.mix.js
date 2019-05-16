let mix = require('laravel-mix');

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
mix.scripts([
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js'
], 'public/js/vendor.js');

mix.scripts([
    'resources/assets/js/converter.js',
], 'public/js/app.js');

mix.sass('resources/assets/sass/player.scss', 'public/css');
mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.version();
