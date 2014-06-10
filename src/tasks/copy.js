'use strict';

var fs = require('fs');

module.exports = function copy(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-copy');

	var templateJson = {}
	if (fs.existsSync('src/config/template.json')) {
		templateJson = grunt.file.readJSON('src/config/template.json');
	} else {
		grunt.fail.warn('file src/template.json does not exists, something went wrong!');
	}

	// Return config
	return {
		root: {
			options: {
				process: function (content, srcpath) {
					return grunt.template.process(content, {data: templateJson});
				}
			},
			files: [{
				expand: true,
				cwd: 'src/root',
				src: ['**/*'],
				dest: ''
			}],
		},
		php_classes: {
			options: {
				process: function (content, srcpath) {
					return grunt.template.process(content, {data: templateJson});
				}
			},
			files: [{
				expand: true,
				cwd: 'src/php/classes',
				src: ['**/*.php'],
				dest: 'php/classes',
			}],
		},
		php_functions: {
			options: {
				process: function (content, srcpath) {
					return grunt.template.process(content, {data: templateJson});
				}
			},
			files: [{
				expand: true,
				cwd: 'src/php/functions',
				src: ['**/*.php'],
				dest: 'php/functions',
			}],
		},
		php_composer: {
			files: [{
				expand: true,
				cwd: 'src/php/composer',
				src: ['**/*'],
				dest: 'php/composer',
			}],
		},
		css: {
			files: [{
				expand: true,
				cwd: 'src/css',
				src: ['**/*.css', '!**/*.min.css'],
				dest: 'css/'
			}],
		},
		js: {
			files: [{
				expand: true,
				cwd: 'src/js',
				src: ['**/*.js', '!**/*.min.js'],
				dest: 'js/'
			}],
		},
		bower_related: {
			files: [{
				//Bootstrap fonts support
				expand: true,
				cwd: 'src/bower/bootstrap-sass-official/vendor/assets/fonts',
				src: ['**/*'],
				dest: 'css/fonts/'
			},{
				//html5shiv support
				expand: true,
				cwd: 'src/bower/html5shiv/dist',
				src: ['**/*.js', '!**/*.min.js'],
				dest: 'js/'
			}],
		},
	};
};
