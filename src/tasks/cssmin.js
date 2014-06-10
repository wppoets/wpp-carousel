'use strict';

module.exports = function cssmin(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	// Options
	return {
		css: {
			sourceMap: true,
			expand: true,
			cwd: 'css/',
			src: ['**/*.css', '!**/*.min.css'],
			dest: 'css/',
			ext: '.min.css'
		}
	};
};
