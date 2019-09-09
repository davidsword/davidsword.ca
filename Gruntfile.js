module.exports = function(grunt) {
	grunt.initConfig({
		/**
		 * Convert readme.txt to GH compat README.md
		 *
		 * One less thing to do myself.
		 */
		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},
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
			readmewatch: {
				files: "./readme.txt",
				tasks: ["wp_readme_to_markdown"]
			},
			jswatch: {
				files: "./assets/js/src/*.js",
				tasks: ["uglify"]
			}
		},
	});

	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );

	grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
};
