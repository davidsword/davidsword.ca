/* eslint-disable */
jQuery(document).ready(function () { // executes when HTML-Document is loaded and DOM is ready

	// NAV ----------------------------------
	nav = jQuery('.icon_hamburger');
	nav.on('click', function (e) {
		e.preventDefault();
		nav.toggleClass('icon_hamburger--white open');
		jQuery('#main > ul').toggle();
		return false;
	});

	// "PROJECTS" highlighting.
	if ( bhc('single-projects') ) {
		jQuery('.menu-item-object-projects').addClass('current-menu-item');
	}

	// "status" highlighting.
	if ( bhc('single-status') || bhc('post-type-archive-status') ) {
		jQuery('.menu-item-object-status').addClass('current-menu-item');
	}

	// "CODE" highlighting.
	if ( bhc('single-post') ) {
		jQuery('.menu-item-4749').addClass('current-menu-item'); // @TODO this should be dynamic.
	}
	if ( bhc('single-post') || ( bhc('archive') && bhc('category') ) ) {
		jQuery('.current_page_parent').addClass('current-menu-item');
	}

	/**
	 * Wrapper for Body Has Class check.
	 *
	 * Makes things eaiser to read.
	 *
	 * @param string the class
	 */
	function bhc(className) {
		return jQuery('body').hasClass(className);
	}

});
