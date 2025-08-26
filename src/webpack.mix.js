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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/purchase.js', 'public/js')
    .js('resources/js/stripe.js', 'public/js')
    .js('resources/js/chat.js', 'public/js')
    .js('resources/js/mypage.js', 'public/js')
    .js('resources/js/evaluation.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
