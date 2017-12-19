var gulp = require('gulp');
var sass = require('gulp-sass');                     	    //编译sass
var path = require('path');
var merge = require('merge-stream');


var folders = ['footer','header','blog','reset','sidebar','site'];


//定义一个sass任务（自定义任务名称）
gulp.task('sass', function () {

    return gulp.src('../static/sass/**/*.scss')

        .pipe(sass())

        .pipe(gulp.dest('../static/sass/'))

})


//将sass文件编译后的css文件放到对应的目录下
gulp.task('mergeCssFile', function(){

    var tasks = folders.map(function(element){
        return gulp.src('../static/sass/'+element + '/*.css', {base: '../static/sass/'+element})
            .pipe(gulp.dest('../static/css/'+element));
    });

    return merge(tasks);
});


//实时监测
gulp.task('watch', function() {
    gulp.watch('../static/sass/**/*.scss', ['sass']);
    gulp.watch('../static/sass/**/*.css', ['mergeCssFile']);
    
});

//定义默认任务
gulp.task('default', ['watch']);
