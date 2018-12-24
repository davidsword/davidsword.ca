/**
 * @see https://github.com/gruntjs/grunt-contrib-less
 * @see https://github.com/gruntjs/grunt-contrib-watch
 */
module.exports = function(grunt) {
	grunt.initConfig({
		// running `grunt less` will compile once
		less: {
			development: {
				options: {
					compress: true
				},
			files: {
				"./assests/css/style.css": "./assests/css/style.less"
			}
		}
	},
	// running `grunt watch` will watch for changes
	watch: {
		files: "./assests/css/*.less",
		tasks: ["less"]
	}
});
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');
};
