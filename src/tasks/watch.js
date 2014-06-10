'use strict';

var fs = require('fs');

module.exports = function watch(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Return config
	return {
		root: {
			files: 'src/root/**/*',
			tasks: ['copy:root'],
		},
		php_classes: {
			files: 'src/php/classes/**/*.php',
			tasks: ['copy:php_classes','phplint:php_classes'],
		},
		php_functions: {
			files: 'src/php/functions/**/*.php',
			tasks: ['copy:php_functions','phplint:php_functions'],
		},
		php_composer: {
			files: 'src/php/composer/**/*',
			tasks: ['copy:php_composer'],
		},
		css: {
			files: ['src/css/**/*.css', 'src/css/**/*.scss', '!src/css/**/*.min.css'],
			tasks: ['csslint', 'compass:css', 'copy:css',  'cssmin:css'],
		},
		js: {
			files: ['src/js/**/*.js', '!src/js/**/*.min.js'],
			tasks: ['jshint', 'copy:js', 'uglify:js'],
		},
		bower_related: {
			files: ['src/bower/**/*'],
			tasks: ['copy:bower_related', 'concat:bower_related', 'uglify:js'],
		},
	};
};
