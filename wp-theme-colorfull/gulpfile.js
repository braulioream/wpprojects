// ---------------------------------------
// CONFIGURATION GULPFILE.JS - WordPress
// ---------------------------------------

const gulp          = require('gulp');
const browserSync   = require('browser-sync').create();
const plumber       = require("gulp-plumber");
const sass          = require('gulp-sass');
const prefix        = require("gulp-autoprefixer");
const concat        = require('gulp-concat');
const sourcemaps    = require("gulp-sourcemaps");
const notify        = require("gulp-notify");

var onError = function(err){
    console.log("Se ha producido un error: ", err.message);
    this.emit("end");
}

// ---------------------------------------
// TAREA SASS - CSS
// ---------------------------------------

gulp.task('sass', () => {
    return gulp.src(['assets/sass/main.sass'])
        .pipe(plumber({errorHandler:onError}))
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(prefix("last 2 versions"))
        .pipe(gulp.dest('assets/css'))
        .pipe(sourcemaps.write('.'))
        .pipe(browserSync.stream())
        //.pipe(notify({message: "SASS tarea finalizada 💯"}))
});

// ---------------------------------------
// TAREA JACASCRIPT - JS
// ---------------------------------------

gulp.task('javascript', function(){
    return gulp.src('assets/javascript/*.js')
        .pipe(plumber({errorHandler:onError}))
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(gulp.dest('assets/js'))
        .pipe(sourcemaps.write())
        .pipe(browserSync.stream())
        //.pipe(notify({message: "JAVASCRIPT tarea finalizada 💯"}))
});

// ---------------------------------------
// RUTA - DIRECTORIO PROYECTO [NAME]
// Ejemplo: C:\wamp64\www\staffdigital\name
// ---------------------------------------

var path = require('path');
var name_project = path.dirname(__filename).split(path.sep)[4]

// ---------------------------------------
// TAREA BROWSERSYNC
// ---------------------------------------

gulp.task('browsersync', () => {
   var files = ['../**/*'];
    browserSync.init(files,{
        open:  'external',
        host:  'wordpress.staffdigital',
        proxy: 'wordpress.staffdigital/'+name_project,
        port:  '8080',
        notify: false
  });
});

// ---------------------------------------
// TAREA WATCH
// ---------------------------------------

gulp.task("watch", function(){
    gulp.watch("./assets/sass/**/*.sass", ["sass"])
    gulp.watch("./assets/javascript/**/*.js", ["javascript"])
});

// ---------------------------------------
// EJECUTAR TAREAS
// ---------------------------------------

gulp.task("default", ["sass", "javascript", "browsersync", "watch"], function(){
    
});