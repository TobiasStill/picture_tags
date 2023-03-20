import "core-js/stable";
import "regenerator-runtime/runtime";
import gulp from 'gulp';
import babelify from 'babelify';
import browserify from 'browserify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';
import concat from 'gulp-concat';

const appBundle = browserify('www/assets/src/app.js', {debug: true})
    .transform(babelify.configure({presets:['@babel/preset-env']}))
    .bundle()
    .pipe(source('bundle.js'))
    .pipe(buffer());

gulp.task('bundle:dist', () => {
    return appBundle
        .pipe(sourcemaps.init({loadMaps: true}))
        // Add transformation tasks to the pipeline here.
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('www/assets/dist/'))
});

gulp.task('bundle:dev', () => {
    return appBundle
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('www/assets'))
});

const vendors = ['vue', 'vuex'];

gulp.task('vendor:js', () => {
    return gulp.src(vendors.map(v => 'node_modules/' + v))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('vendor.js'))
        //.pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('www/assets/dist/'))
        ;
});

const vendorCss = [];

gulp.task('vendor:css', () => {
    return gulp.src(vendorCss.map(v => 'node_modules/' + v))
        .pipe(gulp.dest('www/assets/dist'))
        ;
});

