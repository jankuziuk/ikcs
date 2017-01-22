'use strict';

var gulp = require('gulp'),
	concat = require('gulp-concat'),
	rename = require('gulp-rename'),
	//notify = require("gulp-notify"),
	sass = require("gulp-sass"),
	uglify = require('gulp-uglify'),
	minifyCSS = require('gulp-minify-css');

// sass
gulp.task('sass', function () {
	return gulp.src('sass/**/*.scss')
		.pipe(sass())
		.pipe(concat("theme.css"))
		.pipe(minifyCSS())
		.pipe(rename('theme.min.css'))
		.pipe(gulp.dest('api/css'))
	//.pipe(notify("Success sass!"))
});

//JavaScript
gulp.task('scripts', function() {
	gulp.src([
		'js/libs/jquery-2.2.1.js',
		'js/libs/*.js',
		'js/pages/*.js',
		'js/global.js'
	])
		.pipe(concat('theme.min.js'))
		.pipe(uglify())
		.pipe(gulp.dest('api/js'))
	//.pipe(notify("Success javascript!"))
});

//Watch
gulp.task('watch', function(){
	gulp.watch('sass/**/*.scss', ['sass']);
	gulp.watch('js/**/*.js', ['scripts']);
});

//Default
gulp.task('default', ['sass','scripts','watch']);