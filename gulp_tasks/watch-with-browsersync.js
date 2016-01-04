var gulp        = require('gulp');
var _           = require('underscore');
var browserSync = require('browser-sync').create();
var Elixir      = require('laravel-elixir');
var batch 		= require('gulp-batch');

var srcPaths;
var tasksToRun;

Elixir.extend('watch', function () {
	gulp.task('watch', function(mix) {

		var options = {
	        proxy           : "adomain.com",
	        logPrefix       : "BrowserSync",
	        logConnections  : true,
	        reloadOnRestart : false,
	        notify          : false,
	        host            : "adomain.com"
	    }

		browserSync.init(options);

		
		/**
		* Copied from elixir watch.js
		**/

		var tasks = _.sortBy(Elixir.tasks, 'name');
	    var mergedTasks = {};

	    if (isWatchingBrowserify(tasks)) {
	        Elixir.config.js.browserify.watchify.enabled = true;

	        gulp.start('browserify');
	    }

	    tasks.forEach(function(task) {
	        if (task.name in mergedTasks) {
	            return mergedTasks[task.name].watchers = _.union(mergedTasks[task.name].watchers, task.watchers);
	        }

	        mergedTasks[task.name] = {
	            name: task.name,
	            watchers: Array.isArray(task.watchers) ? task.watchers : [task.watchers]
	        };
	    });

	    _.sortBy(mergedTasks, 'name').forEach(function(task) {
	        if (task.watchers.length > 0) {
	            gulp.watch(task.watchers, batch(Elixir.config.batchOptions, function(events) {
	                events.on('end', gulp.start(task.name) );
	            }));
	        }
	    });

	    /**
	    * End Copy
	    **/

	});

	gulp.task("BrowserSyncReload",  function(){
		browserSync.reload();
	});

});

var isWatchingBrowserify = function(tasks) {
    return _.contains(_.pluck(tasks, 'name'), 'browserify');
};