const mix = require('laravel-mix');
const path = require('path');
require('laravel-vue-lang/mix');

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
 mix
 .lang()
 .webpackConfig({
    resolve: {
        alias: {
            '@lang': path.resolve('./resources/lang'),
        },
    },
    module: {
        rules: [
            {
                test: /resources[\\\/]lang.+\.(php)$/,
                loader: 'php-array-loader',
            },
        ],
    },
})

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

