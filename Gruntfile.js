'use strict';

module.exports = function (grunt) {

	// Load the project's grunt tasks from a directory
	require('grunt-config-dir')(grunt, {
		configDir: require('path').resolve('src/tasks')
	});

	grunt.registerTask('default', [
		'clean',
		'compass',
		'jshint',
		'csslint',
		'concat',
		'copy',
		'phplint',
		'cssmin',
		'uglify',
	]);
	grunt.registerTask('dev', [
		'clean',
		'compass',
		'jshint',
		'csslint',
		'concat',
		'copy',
		'phplint',
		'cssmin',
		'uglify',
		'watch',
	]);
};
