'use strict';

module.exports = function uglify(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-phplint');

	// Options
	return {
		php_classes: {
			files: [{
				src: ['php/classes/**/*.php'],
			}]
		},
		php_functions: {
			files: [{
				src: ['php/functions/**/*.php'],
			}]
		}
	};
};
