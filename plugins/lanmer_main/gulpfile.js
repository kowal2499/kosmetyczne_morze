var gulp = require('gulp');
var rev = require('gulp-rev');
var clean = require('gulp-clean');
var fs = require('fs');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var distFolder = 'assets/build';
var sassAsset = 'assets/src/scss/*.scss';
var compiledSassFolder = 'assets/src/css';
var cssAssets = [
    'assets/src/css/vendor/**/*.css',
    compiledSassFolder + '/*.css'
];
var jsAssets = [
    // 'assets/src/js/vendor/jquery-3.3.1.js',
    'assets/src/js/vendor/bootstrap.min.js',
    'assets/src/js/vendor/ie10-viewport-bug-workaround.js',

    // here you may add other files usually enqueued by wordpress:
    // other wp files
    // ..C:\Users\projects\wp-morze\wp-content\plugins\lanmer_main\assets\src\js\vendor\ie10-viewport-bug-workaround.js

    // remember to load `_app.js` first
    'assets/src/js/_app.js',
    'assets/src/js/app.sideMenu.js',
    'assets/src/js/app.slider.js',
    'assets/src/js/app.sliderStaff.js',
    'assets/src/js/app.sliderTreatment.js',
    'assets/src/js/app.contactForm.js',
    'assets/src/js/app.lightbox.js',
    'assets/src/js/app.frontPageNavigation.js'

    // after adding a new file kill the gulp watch and restart it. It helps.


];

function compileSass() {
    return gulp
        .src(sassAsset)
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest(compiledSassFolder));
}

function bundleCSS() {
    return gulp
        .src(cssAssets)
        .pipe(concat('app.css'))
        .pipe(gulp.dest(distFolder));
}

function concatJS() {
        return gulp
        .src(jsAssets)
        .pipe(concat('app.js', {newLine: ';'}))
        .pipe(uglify())
        .pipe(gulp.dest(distFolder));
}

function hashAssets() {
    return gulp
        .src([
            distFolder + '/app.css',
            distFolder + '/app.js'
        ], {allowEmpty: true})
        .pipe(rev())
        .pipe(gulp.dest(distFolder))
        .pipe(rev.manifest())
        .pipe(gulp.dest(distFolder));
}

function tidyUp() {
    var json = JSON.parse(fs.readFileSync(distFolder + '/rev-manifest.json'));
    return gulp.src([
        distFolder + '/*.css',
        distFolder + '/*.js',
        '!' + distFolder + '/' + json['app.css'],
        '!' + distFolder + '/' + json['app.js'],
        '!' + distFolder + '/app.css',
        '!' + distFolder + '/app.js',
        ], {allowEmpty: true})
        .pipe(clean());
}

function watchFiles() {
    gulp.watch('assets/src/scss/**/*.scss', gulp.series(compileSass, bundleCSS, hashAssets, tidyUp));
    gulp.watch('assets/src/js/**/*.js', gulp.series(concatJS, hashAssets, tidyUp));
}

gulp.task('watch', watchFiles);
