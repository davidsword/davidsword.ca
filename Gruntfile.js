module.exports = function(grunt) {
	grunt.initConfig({
		/**
		 * LESSCSS compiling.
		 *
		 * running `grunt less` will compile once
		 *
		 * @see https://github.com/gruntjs/grunt-contrib-less
		 */
		less: {
			development: {
				options: {
					compress: true
				},
				files: {
					"./assets/css/dist/style.css" : "./assets/css/src/style.less"
				}
			}
		},
		/**
		 * JAVASCRIPT minification.
		 *
		 * running `grunt uglify` will compile once.
		 *
		 * @see https://github.com/gruntjs/grunt-contrib-uglify
		 */
		uglify: {
			my_target: {
				files: {
					'./assets/js/dist/index.js': ['./assets/js/src/*.js']
				}
			}
		},
		/**
		 * WATCH during dev.
		 *
		 * running `grunt watch` will watch for changes and run either.
		 *
		 * @see https://github.com/gruntjs/grunt-contrib-watch
		 */
		watch: {
			lesswatch: {
				files: "./assets/css/src/*.less",
				tasks: ["less"]
			},
			jswatch: {
				files: "./assets/js/src/*.js",
				tasks: ["uglify"]
			}
		},

	});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
};
