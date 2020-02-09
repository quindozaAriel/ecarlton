var gulp = require('gulp');
var cssnano = require('gulp-cssnano');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('login', function(){
	return gulp.src('src/styles/mobile/login.scss')
	.pipe(sass())
	.pipe(cssnano())
	.pipe(gulp.dest('build/styles/mobile/'));
});


gulp.task('watch', function(){
	gulp.watch('src/styles/mobile/*.scss', gulp.series('login'));
});

gulp.task('default',gulp.series('watch'));

