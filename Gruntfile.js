/**
 * @see https://github.com/gruntjs/grunt-contrib-less
 * @see https://github.com/gruntjs/grunt-contrib-watch
 * @see https://github.com/gruntjs/grunt-contrib-uglify
 */
module.exports = function(grunt) {
	grunt.initConfig({
		// LESSCSS compiling.
		// running `grunt less` will compile once
		less: {
			development: {
				options: {
					compress: true
				},
				files: {
					"./assests/css/style-editor.css": "./assests/css/style-editor.less",
					"./assests/css/style.css": "./assests/css/style.less"
				}
			}
		},
		// JAVASCRIPT minification.
		// running `grunt uglify` will compile once.
		uglify: {
			my_target: {
				files: {
					'./assests/js/index.js': ['./assests/js/*.js', '!./assests/js/index.js']
				}
			}
		},
		// WATCH during dev.
		// running `grunt watch` will watch for changes and run either.
		watch: {
			lesswatch: {
				files: "./assests/css/*.less",
				tasks: ["less"]
			},
			jswatch: {
				files: "./assests/js/*.js",
				tasks: ["uglify"]
			}
		},

	});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
};
