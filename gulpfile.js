const gulp = require('gulp');
const del = require('del');
const sass = require('gulp-sass')(require('sass'));
const csso = require('gulp-csso');
const uglify = require('gulp-uglify-es').default;
const rename = require('gulp-rename');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const pckg = require('./package.json');

// Directories
const dirPath = {
    src: './resources',
    dist: './public',
    assets: '/assets',
    assets_dev: '/assets_dev'
};

// Paths
const srcAssets = dirPath.src + dirPath.assets;
const distAssets = dirPath.dist + dirPath.assets;
const distAssetsDev = dirPath.dist + dirPath.assets_dev;

gulp.task('delete', function () {
    return del([distAssets, distAssetsDev]);
});

gulp.task('styles', function () {
    return gulp.src([
            srcAssets + '/scss/tabler.scss',
            srcAssets + '/scss/demo.scss'
        ],
        {
            base: '.'
        })
        .pipe(sass({
            precision: 8,
            outputStyle: 'expanded'
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: pckg.browserslist,
            cascade: false
        }))
        .pipe(concat('base.css'))
        .pipe(gulp.dest(distAssetsDev + '/css/'))
        .pipe(csso({
            comments: false
        }))
        .pipe(gulp.dest(distAssets + '/css/'));
});

gulp.task('css', function () {
    return gulp.src(srcAssets + '/css/**/*.*css')
        .pipe(gulp.dest(distAssetsDev + '/css'))
        .pipe(csso({
            comments: false
        }))
        .pipe(gulp.dest(distAssets + '/css'));
});

gulp.task('css-libs', function () {
    return gulp.src(srcAssets + '/libs/**/*.*css')
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest(distAssetsDev + '/css'))
        .pipe(csso({
            comments: false
        }))
        .pipe(gulp.dest(distAssets + '/css'));
});

gulp.task('js', function () {
    return gulp.src(srcAssets + '/js/**/*.*js')
        .pipe(gulp.dest(distAssetsDev + '/js'))
        .pipe(uglify())
        .pipe(gulp.dest(distAssets + '/js'));
});

gulp.task('js-libs', function () {
    return gulp.src(srcAssets + '/libs/**/*.*js')
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest(distAssetsDev + '/js'))
        .pipe(uglify())
        .pipe(gulp.dest(distAssets + '/js'));
});

gulp.task('js-views', function () {
    return gulp.src(dirPath.src + '/views/**/*.*js')
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest(distAssetsDev + '/js'))
        .pipe(uglify())
        .pipe(gulp.dest(distAssets + '/js'));
});

gulp.task('files', function () {
    return gulp.src([
        srcAssets + '/fonts/**/*.*',
        srcAssets + '/images/**/*.*'
    ], {base: srcAssets})
        .pipe(gulp.dest(distAssetsDev))
        .pipe(gulp.dest(distAssets));
});

gulp.task('watch', function () {
    gulp.watch(srcAssets + '/scss/**/*.scss', gulp.series('styles'));
    gulp.watch(srcAssets + '/css/**/*.*css', gulp.series('css'));
    gulp.watch(srcAssets + '/libs/**/*.*css', gulp.series('css-libs'));
    gulp.watch(srcAssets + '/js/**/*.*js', gulp.series('js'));
    gulp.watch(srcAssets + '/libs/**/*.*js', gulp.series('js-libs'));
    gulp.watch(dirPath.src + '/views/**/*.*js', gulp.series('js-views'));
});


gulp.task('build',
    gulp.series(
        'delete',
        'styles',
        'css',
        'css-libs',
        'js',
        'js-libs',
        'js-views',
        'files'
    )
);
