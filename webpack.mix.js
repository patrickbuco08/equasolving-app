const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({ node: { fs: 'empty' }});

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .js('resources/js/utilities/request.js', 'public/js/utilities')
    .js('resources/js/utilities/pvpService.js', 'public/js/utilities')
    .js('resources/js/sfx.js', 'public/js/sfx/')
    .js('resources/js/pvp.js', 'public/js/')
    .js('resources/js/navigator.js', 'public/js/')





