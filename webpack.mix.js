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
mix.options({
  processCssUrls: false // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
});

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/main.scss', 'public/css');

//mix.copyDirectory('resources/assets/images', 'public/images');
//mix.copyDirectory('resources/assets/fonts', 'public/fonts');