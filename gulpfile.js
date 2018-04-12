var gulp = require('gulp');
var browserSync = require('browser-sync');

gulp.task('default', function () {
    browserSync.init({
        open: true,
        port: 80,
        watchOptions: {
            ignoreInitial: true
        },
        server: {
            baseDir: './',
        }
    });
});