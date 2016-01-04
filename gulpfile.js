var elixir = require('laravel-elixir');
var gulp        = require('gulp');
var watch = require('./gulp_tasks/watch-with-browsersync');


elixir(function(mix) {

    mix.sass('app.scss');
    mix.browserify('main.js');
    mix.version(['public/css/app.css', 'public/js/main.js']);
    mix.task('BrowserSyncReload', ['public/**/*', 'resources/views/**/*']);
    mix.watch();

});
