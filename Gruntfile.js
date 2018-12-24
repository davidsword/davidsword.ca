module.exports = function(grunt) {
	grunt.initConfig({
		// running `grunt less` will compile once
		less: {
			development: {
				options: {
					paths: ["./assests/css"],
					yuicompress: true
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
