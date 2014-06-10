'use strict';

module.exports = function jshint(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-csslint');

	// Options
	return {
		src: ['src/css/**/*.css'],
	};
};
