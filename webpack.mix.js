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

mix.webpackConfig({
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        }
    }
});

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/app2.js', 'public/js')
   .js('resources/assets/js/admin_dashboard.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
