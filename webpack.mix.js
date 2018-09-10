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

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/app_front.js', 'public/js')
    .js('resources/assets/js/app_admin.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/admin/sb-admin.scss', 'public/css/admin')
    .version();

mix.copy('resources/assets/uploads', 'public/uploads', false);
mix.copy('resources/assets/js/admin/', 'public/js/admin');
mix.browserSync('http://dobro.ua');

if (mix.inProduction()) {
    mix.version();
}
