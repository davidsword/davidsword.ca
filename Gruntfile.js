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
					"./assests/css/dist/style-editor.css": "./assests/css/src/style-editor.less",
					"./assests/css/dist/style.css":        "./assests/css/src/style.less"
				}
			}
		},
		// JAVASCRIPT minification.
		// @see https://github.com/gruntjs/grunt-contrib-uglify
		// running `grunt uglify` will compile once.
		/*uglify: {
			my_target: {
				files: {
					'./assests/js/assests': ['./assests/js/*.js', '!./assests/js/assests']
				}
			}
		},*/
		// WATCH during dev.
		// running `grunt watch` will watch for changes and run either.
		watch: {
			lesswatch: {
				files: "./assests/css/src/*.less",
				tasks: ["less"]
			}
			/*jswatch: {
				files: "./assests/js/*.js",
				tasks: ["uglify"]
			}*/
		},

	});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	//grunt.loadNpmTasks('grunt-contrib-uglify');
};
