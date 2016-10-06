module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bowercopy: {
            options: {
                srcPrefix: 'bower_components',
                destPrefix: 'web/assets'
            },
            scripts: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.js',
                    'js/jquery-ui.js': 'jquery-ui/jquery-ui.js',
                    'js/bootstrap.js': 'bootstrap/dist/js/bootstrap.js',
                    'js/requirejs.js': 'requirejs/require.js',
                    'js/backbone.js': 'backbone/backbone.js',
                    'js/underscore.js': 'underscore/underscore.js',
                    'js/gridster.js': 'gridster-js/dist/jquery.gridster.min.js',
                    'js/image-picker.js': 'image-picker/image-picker/image-picker.min.js',
                    'js/backbone.localStorage.js': 'backbone.localStorage/backbone.localStorage-min.js',
                    'js/backbone-nested.js': 'backbone-nested-model/backbone-nested.js',
                    'js/backbone-associations.js': 'backbone-associations/backbone-associations-min.js',
                    
                }
            },
            stylesheets: {
                files: {
//                    'css/bootstrap.css': 'bootstrap/dist/css/bootstrap.css',
                    'css/font-awesome.css': 'font-awesome/css/font-awesome.css',
                }
            },
            fonts: {
                files: {
                    'fonts': ['font-awesome/fonts', 'bootstrap/fonts']
                }
            }

            
        },
        cssmin: {
            bundled: {
                src: 'web/assets/css/benagro.css',
                dest: 'web/assets/css/benagro.min.css'
            }
        },
        uglify: {
            options: {
                compress: {
                    drop_console: true 
                }
            },
            js: {
                files: {
                    'web/assets/js/benagro.min.js': ['web/assets/js/benagro.js']
                }
            }
        },
        concat: {
            options: {
                stripBanners: true
            },
            css: {
                src: [
                    //'web/assets/css/bootstrap.css',
                    'web/assets/css/font-awesome.css',
                    'src/AppBundle/Resources/public/css/*.css'
                ],
                dest: 'web/assets/css/benagro.css'
            },
            js: {
                src: [
                    //'src/AppBundle/Resources/public/js/*.js',
                    'web/bundles/fosjsrouting/js/router.js',
                    'web/js/fos_js_routes.js'
                ],
                dest: 'web/assets/js/benagro.js'
            }
        },
        copy: {
            images: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/images',
                src: '*',
                dest: 'web/assets/images/'
            },
            fonts: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/fonts',
                src: '*',
                dest: 'web/assets/fonts/'
            },
            js: {
                expand: true,
                cwd: 'src/AppBundle/Resources/public/js',
                src: ['*', '*/*', '*/*/*', '*/*/*/*'],
                dest: 'web/js/'
            }
        }
    });

    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('default', ['bowercopy', 'copy', 'concat', 'cssmin', 'uglify']);
};