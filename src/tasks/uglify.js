'use strict';

module.exports = function uglify(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-uglify');

	// Options
	return {
		js: {
			files: [{
				expand: true,
				cwd: 'js',
				src: ['**/*.js', '!**/*.min.js'],
				dest: 'js',
				ext: '.min.js'
			}]
		}
	};
};
