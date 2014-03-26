//Base requires
var 	gulp      = require('gulp'),
		map       = require('map-stream'),
		compass   = require('gulp-compass'),
		minifycss = require('gulp-minify-css'),
		rename    = require('gulp-rename'),
		uglify    = require('gulp-uglify'),
		rimraf    = require('gulp-rimraf'),
		concat    = require('gulp-concat'),
		sass      = require('gulp-ruby-sass'),
		shell     = require('gulp-shell');

var src_paths = {
	scripts: 'src/scripts/**/*.js',
	styles: 'src/styles/*.scss',
	svnrelease: [
		'**/*',
		'!package.json',
		'!gulpfile.js',
		'!build/**',
		'!build',
		'!node_modules/**',
		'!node_modules',
		'!src/styles/**',
		'!src/styles',
		'!src/scripts/**',
		'!src/scripts',
	],
};

var dest_paths = {
	scripts: 'scripts',
	styles: 'styles',
	images: 'images',
	fonts: 'fonts',
	svnrelease: 'build/svn/trunk',
	clean: [ 'scripts/**/*', 'styles/**/*'],
};


// Task - default
gulp.task('default', ['clean'], function() {
	gulp.start('styles', 'scripts');
});

// Task - clean
gulp.task('clean', function() {
	gulp.src(dest_paths.clean, {read: false})
		.pipe(rimraf());
});

// Task - styles
gulp.task('styles', function() {
	gulp.src(src_paths.styles)
        .pipe(sass())
		.pipe(gulp.dest(dest_paths.styles))
		.pipe(rename({ suffix: '.min' }))
		.pipe(minifycss())
		.pipe(gulp.dest(dest_paths.styles));
});

// Task - scripts
gulp.task('scripts', function() {
	gulp.src(src_paths.scripts)
		.pipe(gulp.dest(dest_paths.scripts))
		.pipe(rename({ suffix: '.min' }))
		.pipe(uglify())
		.pipe(gulp.dest(dest_paths.scripts));
});

// Task - svnrelease
gulp.task('svnrelease', function() {
	gulp.src(src_paths.svnrelease)
		.pipe(gulp.dest(dest_paths.svnrelease));
		//.pipe(map(
		//	function(file, callback){
		//		console.log( file.path );
		//		return callback(null, file);
		//	}
		//));
});
