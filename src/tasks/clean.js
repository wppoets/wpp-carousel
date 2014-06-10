'use strict';

module.exports = function clean(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-clean');

	// return config
	return {
		root: [
			'*',
			'!clear_reset_hard.sh', //Added for rapid teseting
			'!css',
			'!composer.json',
			'!Gruntfile.js',
			'!images',
			'!js',
			'!node_modules',
			'!php',
			'!package.json',
			'!README.md',
			'!CONTRIBUTING.md',
			'!src'
		],
		php: [
			'php/**/*',
			'!php',
			'!php/classes',
			'!php/functions',
			'!php/vendor',
		],
		css: [
			'css/**/*',
			'!css',
			'!css/fonts',
		],
		js: [
			'js/**/*',
			'!js',
		],
		images: [
			'images/**/*', 
			'!images',
		]
	};
};
