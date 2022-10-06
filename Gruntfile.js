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
					'./wp-content/themes/dsca-theme/README.md': './wp-content/themes/dsca-theme/readme.txt'
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
					"./dsca-theme/assets/css/dist/style.css" : "./wp-content/themes/dsca-theme/assets/css/src/style.less"
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
					'./dsca-theme/assets/js/dist/index.js': ['./wp-content/themes/dsca-theme/assets/js/src/*.js']
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
				files: "./wp-content/themes/dsca-theme/assets/css/src/*.less",
				tasks: ["less"]
			},
			readmewatch: {
				files: "./wp-content/themes/dsca-theme/readme.txt",
				tasks: ["wp_readme_to_markdown"]
			},
			jswatch: {
				files: "./wp-content/themes/dsca-theme/assets/js/src/*.js",
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
