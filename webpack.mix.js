let mix = require('laravel-mix');

mix.copy('resources/js', 'public/js')
   .copy('resources/css', 'public/css');