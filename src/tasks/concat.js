'use strict';

module.exports = function concat(grunt) {
	// Load task
	grunt.loadNpmTasks('grunt-contrib-concat');

	// Options
	return {
		bower_related: {
			files: [{ /* //Disabled for now
				'js/bootstrap.js': [ //Bootstrap js files need to be included in order (**sigh**)
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/carousel.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/collapse.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/scrollspy.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js',
					'src/bower/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/affix.js'
				] */
			}]
		}
	};
};
