const mix = require('laravel-mix');
const path = require('path');

require('laravel-mix-workbox');
// require('laravel-mix-polyfill');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    // .polyfill({
    //     enabled: true,
    //     useBuiltIns: 'usage',
    //     entryPoints: 'es',
    //     targets: '> 0.25%, not dead',
    // })
    .webpackConfig({
        resolve: {
            fallback: {
                crypto: require.resolve('crypto-browserify'),
                stream: require.resolve('stream-browserify'),
            },
            alias: {
                '@': path.resolve('resources/js'),
                '@pages': path.resolve('resources/js/pages'),
                '@components': path.resolve('resources/js/components'),
            }
        },
    })
    .vue({ version: 3 })
    .generateSW()
    .version();
