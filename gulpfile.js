'use strict';

var gulp = require('gulp')
  , $ = require('gulp-load-plugins')();

gulp.task('styles', function () {
  return gulp.src('less/*.less')
    .pipe($.plumber())
    .pipe($.less())
    .pipe($.autoprefixer())
    .pipe($.csso())
    .pipe(gulp.dest('design'))
    .pipe($.livereload())
    .pipe($.size({
      showFiles: true
    }));
});

gulp.task('default', ['styles']);

gulp.task('watch', function () {
  $.livereload.listen();

  gulp.watch('less/**/*.less', ['styles']);
});

module.exports = gulp;
