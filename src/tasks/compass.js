'use strict';

module.exports = function compass(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-compass');

	// Return config
	return {
		css: {
			options: {
				config: 'src/config/config.rb'
			}
		}
	};
};
