jQuery(document).ready(function() { // executes when HTML-Document is loaded and DOM is ready

	// remove "SHOW MORE" on small GISTS
	// if (jQuery('html body .oembed-gist')) {
	// 	jQuery('html body .oembed-gist').click(function(){
	// 		jQuery(this).addClass('reveal');
	// 	})
	// }

	// remove "SHOW MORE" on small GISTS
	// setTimeout(function(){
	// 	if (jQuery('.oembed-gist')) {
	// 		jQuery('.oembed-gist').each(function(){
	// 			if (jQuery(this).height() > 300) {
	// 				jQuery(this).addClass('big-gist')
	// 			} else {
	// 				jQuery(this).addClass('reveal')
	// 				jQuery(this).addClass('small-gist')
	// 			}
	// 		})
	// 	}
	// }, 1000);

	// MOBILE NAV ----------------------------------
	jQuery('#hamburger').on('click',function(){
		jQuery('#hamburger').toggleClass('open');
	});

	// HIGHLIGHT NAVIGATION ----------------------------------
	if (jQuery('body').hasClass('single-projects')) {
		jQuery('.menu-item-object-projects').addClass('current-menu-item');
	}
	if (jQuery('body').hasClass('post-type-archive-images') ||
		jQuery('body').hasClass('post-type-archive-art') ||
		jQuery('body').hasClass('post-type-archive-ramblings')) {
			jQuery('.menu-item-4707').addClass('current-menu-item');
	}
	if (jQuery('body').hasClass('single-post')) {
		jQuery('.current_page_parent').addClass('current-menu-item');
	}

	// FIRE LIGHTBOX ----------------------------------
	if (jQuery('.grid.images')) {
		const gallery = jQuery('.grid.images a[data-lightbox]').featherlightGallery({
	        previousIcon: '&#9664;',
	        nextIcon: '&#9654;',
	        galleryFadeIn: 300,
	        galleryFadeOut: 300
	    });
    }

});
