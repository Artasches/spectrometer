var gulp = require('gulp');
var browserSync = require('browser-sync');

gulp.task('default', function () {
    console.log('default task')
    browserSync.init({
        open: true,
        watchOptions: {
            ignoreInitial: true
        },
        server: {
            baseDir: './www',
        }
    });
});