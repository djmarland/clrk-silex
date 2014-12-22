module.exports = function (grunt) {
    var sassFilesArray = [{
        expand: true,
        cwd: 'app/assets/css',
        src: ['**/*.scss', '!**/_*.scss'],
        rename: function(destBase, destPath, options) {
            return options.cwd + '/../../../web/assets/css/' + destPath.replace(/\.scss/, '.css');
        },
    }];

    // Project configuration.
    grunt.initConfig({
        assetsPath: 'app/assets',
        outputPath: 'web/assets',

        // Store your Package file so you can reference its specific data whenever necessary
        pkg: grunt.file.readJSON('package.json'),

        jshint: {
            // Prefix a path with ! to ignore it
            files: [
                'Gruntfile.js',
                '<%=assetsPath%>/js/**/*.js',
                '!<%=assetsPath%>/js/vendor/**/*.js',
            ],
            options: {
                jshintrc: '.jshintrc'
            }
        },

        requirejs: {
            options: {
                baseUrl: '<%=assetsPath%>/js',
                dir: '<%=outputPath%>/js',
                optimize: 'uglify2',
                skipDirOptimize: true,
                optimizeCss: false,
                generateSourceMaps: true,
                preserveLicenseComments: false,
                modules: [
                    { name: 'main' }
                ],
            },
            dev: {
                options: {
                    optimize: 'none'
                }
            },
            dist: {}
        },

        qunit: {
            all: [ '<%=assetsPath%>/js-test/**/*.html' ]
        },

        sass: {
            options: {
                includePaths: [
                    // '<%=assetsPath%>/css',
                ],
                outputStyle: 'compressed',
                precision: 8
            },
            dev: {
                files: sassFilesArray,
                options: {
                    sourceMap: true
                },
            },
            dist :{
                files: sassFilesArray,
                 options: {
                    sourceMap: false
                },
            }
        },

        copy: {
            assets: {
                expand: true,
                cwd: '<%=assetsPath%>',
                src: [
                    'img/**'
                ],
                dest: '<%=outputPath%>'

            }
        },

        // Run: `grunt watch` from command line for this section to take effect
        watch: {
            options: {
              nospawn: true,
              livereload: true
            },
            scripts: {
                files: [
                    '<%=assetsPath%>/js/**/*.js',
                    '<%=assetsPath%>/js-test/**/*.js'
                ],
                tasks: ['requirejs:dev', 'jshint'/*, 'qunit'*/]
            },
            sass: {
                files: ['<%=assetsPath%>/css/**/*.scss'],
                tasks: ['sass:dev']
            },
            otherAssets: {
                files: ['<%assetsPath%>/img/**'],
                tasks: ['copy:assets']
            }
        }

    });

    // Load NPM Tasks
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-requirejs');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-sass');


    // Default Task
    grunt.registerTask('default', ['sass:dev', 'requirejs:dev', 'jshint', 'copy:assets'/*, 'qunit'*/]);

    // CI Task
    grunt.registerTask('ci', ['sass:dist', 'requirejs:dist', 'jshint', 'copy:assets'/*, 'qunit'*/]);
};
