/**
 * @see https://github.com/gruntjs/grunt-contrib-less
 * @see https://github.com/gruntjs/grunt-contrib-watch
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
					"./assets/css/dist/style-editor.css": "./assets/css/src/style-editor.less",
					"./assets/css/dist/style.css":        "./assets/css/src/style.less"
				}
			}
		},
		// JAVASCRIPT minification.
		// @see https://github.com/gruntjs/grunt-contrib-uglify
		// running `grunt uglify` will compile once.
		/*uglify: {
			my_target: {
				files: {
					'./assets/js/index.js': ['./assets/js/*.js', '!./assets/js/index.js']
				}
			}
		},*/
		// WATCH during dev.
		// running `grunt watch` will watch for changes and run either.
		watch: {
			lesswatch: {
				files: "./assets/css/src/*.less",
				tasks: ["less"]
			}
			/*jswatch: {
				files: "./assets/js/*.js",
				tasks: ["uglify"]
			}*/
		},

	});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	//grunt.loadNpmTasks('grunt-contrib-uglify');
};
