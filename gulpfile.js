const gulp = require('gulp')
const browserify = require('browserify')
const source = require('vinyl-source-stream')
const tsify = require('tsify')
const uglify = require('gulp-uglify')
const sourcemaps = require('gulp-sourcemaps')
const buffer = require('vinyl-buffer')
const sass = require('gulp-sass')
const cleanCss = require('gulp-clean-css')
const rename = require('gulp-rename')
const postcss = require('gulp-postcss')
const autoprefixer = require('autoprefixer')
const eslint = require('gulp-eslint')
const ts = require('gulp-typescript')

const tsProject = ts.createProject('./tsconfig.json')

const names = {
  bundleName: 'bohemia-ui.bundle',
  declarationsName: 'bohemia-ui'
}

const paths = {
  cssSrc: 'assets/src/styles/index.scss',
  cssDist: 'public/build/styles/',
  jsSrc: 'assets/src/scripts/index.ts',
  jsDist: 'public/build/scripts/',
  jsSrcDeclare: 'assets/src/scripts/**/*.ts',
  jsDistDeclare: 'assets/dist/types/'
}

function minifyJs (src, out, name, debug) {
  return browserify({
    basedir: '.',
    debug: debug,
    entries: src,
    cache: {},
    packageCache: {}
  })
    .plugin(tsify)
    .bundle()
    .on('error', swallowError)
    .pipe(source(name + '.min.js'))
    // .pipe(eslint())
    // .pipe(eslint.format())
    // .pipe(eslint.failAfterError())
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(uglify())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(out))
    .pipe(gulp.dest('/' + out))
    .on('error', swallowError)
}

function scriptsDeclarations (src, out, name) {
  return gulp.src(src)
    .pipe(tsProject()).dts
    .pipe(gulp.dest(out))
}

function scripts (src, out, name, debug, minify) {
  const stream = browserify({
    basedir: '.',
    debug: debug,
    entries: src,
    cache: {},
    packageCache: {}
  })
    .plugin(tsify)
    .bundle()
    .on('error', swallowError)
    .pipe(source(name + '.js'))
    .pipe(buffer())
    .pipe(sourcemaps.init({ loadMaps: true }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(out))
    .pipe(gulp.dest('/' + out))

  if (minify) {
    minifyJs(src, out, name, debug)
  }

  return stream
}

function styles (src, out, name, minify) {
  const stream = gulp.src(src)
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: ['node_modules']
    }).on('error', sass.logError))
    .pipe(postcss([autoprefixer]))
    .pipe(sourcemaps.write())
    .pipe(rename({ basename: name }))
    .pipe(gulp.dest(out))
    .pipe(gulp.dest('/' + out))

  if (minify) {
    stream.pipe(cleanCss())
      .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest(paths.cssDist))
      .pipe(gulp.dest('/' + paths.cssDist))
  }
  return stream
}

function swallowError (error) {
  console.log(error.toString())
  this.emit('end')
}

function declareStructure () {
  return scriptsDeclarations(paths.jsSrcDeclare, paths.jsDistDeclare, names.declarationsName)
}

function stylesApp () {
  return styles(paths.cssSrc, paths.cssDist, names.bundleName, true)
}

function scriptsApp () {
  return scripts(paths.jsSrc, paths.jsDist, names.bundleName, false, true)
}

function watchJS () {
  gulp.watch(['assets/src/scripts/**/*.ts'], gulp.series(scriptsApp))
}

function watchCSS () {
  gulp.watch([
    'assets/src/styles/**/*.scss',
  ], gulp.series(stylesApp))
}

// APP
exports.buildCSS = gulp.series(stylesApp)
exports.buildJS = gulp.series(scriptsApp)
exports.buildApp = gulp.series(exports.buildCSS, exports.buildJS)

exports.watchCSS = gulp.parallel(watchCSS)
exports.watchJS = gulp.parallel(watchJS)
exports.watch = gulp.parallel(exports.watchCSS, exports.watchJS)

// PROD
exports.declare = gulp.series(declareStructure)

// GLOBAL
exports.buildAll = gulp.series(exports.buildApp)

exports.watchAll = gulp.parallel(exports.watch)

exports.default = gulp.series(exports.buildAll)
