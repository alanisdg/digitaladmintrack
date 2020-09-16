module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
        options: {
            manage: false
        },
        my_target1: {
            files: [
                {
                    'public/js/reports2.js':
                    [
                        
                        'js/jquery.easing.1.3.js',
                        'js/markerAnimate.js',
                        'js/SlidingMarker.min.js',
                        'js/sweetalert.min.js',
                        'js/bootstrap-datepicker.min.js',
                        'js/mrklbl.js',
                        'js/loader.js' ,
                        'js/socket.io.js',
                        'js/notify.min.js',
                        'js/notifications.js',
                        'js/jewelbutton.js', 
                        'js/chosen.jquery.js'


                    ]
                }
            ]
        },
        my_target2: {
            files: [
                {
                    'public/js/master.js':
                    [ 
                        'js/jquery-3.1.1.min.js',
                        'js/socket.io.js',
                        'js/jquery.easing.1.3.js',
                        'js/markerAnimate.js',
                        'js/SlidingMarker.min.js',
                        'js/sweetalert.min.js',
                        'js/notify.min.js',
                        'js/mrklbl.js',
                        'js/jewelbutton.js',
                        'js/notifications.js',
                        'js/map-devices.js',
                        'js/timer.js',
                        'js/markerclusterer.js',
                        'js/infobox.js',
                        'js/loader.js',
                        'js/jquery-confirm.js'
                    ]
                }
            ]
        },
        my_target3: {
            files: [
                {
                    'public/js/master_admin.js':
                    [
                        'js/jquery-confirm.js',
                        'js/admin.js',
                        'js/SlidingMarker.min.js',
                        'js/sweetalert.min.js'

                    ]
                }
            ]
        },
        my_target4: {
            files: [
                {
                    'public/js/drawing.js':
                    [ 
                        'js/jquery-3.1.1.min.js',
                        'js/jquery.easing.1.3.js',
                        'js/markerclusterer.js',
                        'js/drawing.js', 
                        'js/sweetalert.min.js',
                        'js/multiple.js',
                        'js/socket.io.js',
                        'js/notify.min.js',
                        'js/jewelbutton.js',
                        'js/notifications.js',
                        'js/mrklbl.js',
                        'js/loader.js'
                        
                    ]
                }
            ]
        },
        my_target6: {
            files: [
                {
                    'public/js/boxs.js':
                    [ 
                        'js/jquery-3.1.1.min.js',
                        
                       'js/show_geofence.js',
                       'js/markerclusterer.js',
                       'js/mrklbl.js',
                        'js/loader.js'
                       
                        
                    ]
                }
            ]
        },
        my_target5: {
            files: [
                {
                    'public/js/travels.js':
                    [

                        'js/jquery-3.1.1.min.js',
                        'js/bootstrap-datepicker.min.js',
                        'js/moment.js',
                        'js/bootstrap-datetimepicker.js',
                        'js/datepair.js',
                        'js/jquery.datepair.min.js',
                        'js/travels.js',
                        'js/jewelbutton.js',
                        'js/socket.io.js',
                        'js/notify.min.js',
                        'js/notifications.js',
                        'js/jquery-confirm.js',
                        'js/multiple.js',
                        'js/chosen.jquery.js',
                        'js/mrklbl.js',
                        'js/timer.js',
                        'js/map-icons.min.js',
                        'js/markerclusterer.js',
                        'js/loader.js'
                    ]
                }
            ]
        }
    },
    less:{
        develpment:{
            options:{
                compress:true,
                yuicompress:true,
                optimization:2
            },
            files:{
                "public/css/usamex.css" : "less/bootstrap.less"
            }
        },
        admin:{
            options:{
                compress:true,
                yuicompress:true,
                optimization:2
            },
            files:{
                "public/css/admin.css" : "less/admin/admin.less"
            }
        }
    },
    watch:{
        options:{
            livereload:true
        },
        less:{
            files:'less/**/*.less',
            tasks: ['less']
        },
        app:{
            files:['app/**','resources/**','routes/**','js/**']
        },
        uglify:{
            files:['js/**'],
            tasks: ['uglify']
        }
    }

  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');

  // Default task(s).
  grunt.registerTask('default', ['less','uglify','watch']);

};
