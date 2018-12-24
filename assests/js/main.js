/* eslint-disable */
jQuery(document).ready(function() { // executes when HTML-Document is loaded and DOM is ready

	// MOBILE NAV ----------------------------------
	jQuery('#hamburger').on('click',function(){
		jQuery('#hamburger').toggleClass('open');
	});

	// HIGHLIGHT NAVIGATION ----------------------------------
	if (jQuery('body').hasClass('single-projects')) {
		jQuery('.menu-item-object-projects').addClass('current-menu-item'); // "PROJECTS"
	}
	if (jQuery('body').hasClass('post-type-archive-images') ||
		jQuery('body').hasClass('post-type-archive-art') ) {
		// ||
		//jQuery('body').hasClass('single-status'))

		jQuery('.menu-item-4707').addClass('current-menu-item'); // "ABOUT"
	}

	if (
		jQuery('body').hasClass('single-status') || jQuery('body').hasClass('post-type-archive-status')
	) {
			jQuery('.menu-item-object-status').addClass('current-menu-item'); // "status"
	}

	if (jQuery('body').hasClass('single-post')) {
			jQuery('.menu-item-4749').addClass('current-menu-item'); // "CODE"
	}

	if (
        jQuery('body').hasClass('single-post') ||
	    (jQuery('body').hasClass('archive') && jQuery('body').hasClass('category'))
    ) {
		jQuery('.current_page_parent').addClass('current-menu-item'); // "CODE"
	}

});
