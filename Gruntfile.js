module.exports = function (grunt) {
  'use strict';

  // Force use of Unix newlines
  grunt.util.linefeed = '\n';

  RegExp.quote = function (string) {
    return string.replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&')
  }

  var fs = require('fs')

  // Project configuration.
  grunt.initConfig({

    // Metadata.
    pkg: grunt.file.readJSON('package.json'),
    banner: '/*!\n' +
              ' * <%= pkg.name %> v<%= pkg.version %>\n' +
              ' * Built using Strapit v<%= pkg.strapitVersion %> \n' + 
              ' * Homepage: <%= pkg.homepage %>\n' +
              ' * GitHub: <%= pkg.repository.url %>\n' +
              ' * Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
              ' */\n',

    // Task configuration.

    jshint: {
      options: {
        jshintrc: 'js/.jshintrc'
      },
      gruntfile: {
        src: 'Gruntfile.js'
      },
      src: {
        src: ['js/*.js']
      },
      assets: {
        src: ['js/<%= pkg.name %>.js']
      }
    },

    csslint: {
      options: {
        csslintrc: 'less/.csslintrc'
      },
      src: [
        'css/<%= pkg.name %>.css'
      ]
    },

    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: false
      },
      scriptFiles: {
        src: [
          'js/plugins/bootstrap.js',
          'js/plugins/jquery.hover-intent.js',
          'js/plugins/picturefill.js',
          'js/plugins/fastclick.js',
          'js/plugins/util.js',
          'js/app.js'
        ],
        dest: 'js/<%= pkg.name %>.js'
      }
    },

    uglify: {
      bootstrap: {
        options: {
          banner: '<%= banner %>\n',
          report: 'min'
        },
        src: ['<%= concat.scriptFiles.dest %>'],
        dest: 'js/<%= pkg.name %>.min.js'
      },
    },

    less: {
      compileCore: {
        options: {
          strictMath: true,
          sourceMap: true,
          outputSourceFiles: true,
          sourceMapURL: 'css/<%= pkg.name %>.css.map',
          sourceMapFilename: 'css/<%= pkg.name %>.css.map'
        },
        files: {
          'css/<%= pkg.name %>.css': 'less/strapit.less'
        }
      },
      minify: {
        options: {
          cleancss: true,
          report: 'min'
        },
        files: {
          'css/<%= pkg.name %>.min.css': 'css/<%= pkg.name %>.css'
        }
      }
    },

    usebanner: {
      dist: {
        options: {
          position: 'top',
          banner: '<%= banner %>'
        },
        files: {
          src: [
            'css/<%= pkg.name %>.css',
            'css/<%= pkg.name %>.min.css'
          ]
        }
      }
    },

    csscomb: {
      sort: {
        options: {
          config: 'less/.csscomb.json'
        },
        files: {
          'css/<%= pkg.name %>.css': ['css/<%= pkg.name %>.css']
        }
      }
    },

    watch: {
      reloader: {
        files: ['*.html', '*.php', '/*/*.html', '/*/*.php'],
        options: {
          livereload: true
        }
      },
      src: {
        files: '<%= jshint.src.src %>',
        tasks: ['jshint:src'],
        options: {
          livereload: true
        }
      },
      less: {
        files: ['less/*.less', 'less/*/*.less'],
        tasks: ['less', 'csscomb', 'usebanner'],
        options: {
          livereload: true
        }
      }
    },

    sed: {
      versionNumber: {
        pattern: (function () {
          var old = grunt.option('oldver')
          return old ? RegExp.quote(old) : old
        })(),
        replacement: grunt.option('newver'),
        recursive: true
      }
    }

  });


  // These plugins provide necessary tasks.
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

  // JS distribution task.
  grunt.registerTask('dist-js', ['concat', 'uglify']);

  // CSS distribution task.
  grunt.registerTask('dist-css', ['less', 'csscomb', 'usebanner']);

  // Default task.
  grunt.registerTask('default', ['dist-css', 'dist-js']);

  // Version numbering task.
  // grunt change-version-number --oldver=A.B.C --newver=X.Y.Z
  // This can be overzealous, so its changes should always be manually reviewed!
  grunt.registerTask('change-version-number', ['sed']);

};