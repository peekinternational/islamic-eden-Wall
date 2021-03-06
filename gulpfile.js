var elixir = require('laravel-elixir');

//require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
/*

 elixir(mix => {
 mix.sass('app.scss')
 .webpack('app.js');
 });
 */


elixir(function(mix) {
    mix.styles([
        'bootstrap.min.css',
        'main.css',
        'animations.css',
        'fonts.css'
    ], 'public/assets/css/style.css');

});


elixir(function(mix) {
    mix.scripts([
        'compressed.js',
        'main.js',
        'plugins.js'
    ],'public/assets/js/script.js');
});