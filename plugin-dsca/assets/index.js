/* eslint-disable */
jQuery(document).ready(function() { // executes when HTML-Document is loaded and DOM is ready

	// FIRE LIGHTBOX ----------------------------------
	if (jQuery('.grid.images')) {
		const gallery = jQuery('.grid.images a[data-lightbox]').featherlightGallery({
			previousIcon: '&#9664;',
			nextIcon: '&#9654;',
			galleryFadeIn: 300,
			galleryFadeOut: 300
		});
	}

	// remove "SHOW MORE" on small GISTS
	if (jQuery('html body .oembed-gist')) {
		jQuery('html body .oembed-gist').click(function(){
			jQuery(this).addClass('reveal');
		})
	}

	if (jQuery('.skilltags')) {
		var skills = jQuery('.skilltags').text().split(", ");
		var newskills = '';
		for (i = 0; i != skills.length; i++) {
			newskills += "<code>"+skills[i]+"</code> ";
		}
		jQuery('.skilltags').html(newskills)
	}

	// remove "SHOW MORE" on small GISTS
	setTimeout(function(){
		if (jQuery('.oembed-gist')) {
			jQuery('.oembed-gist').each(function(){
				if (jQuery(this).height() > 300) {
					jQuery(this).addClass('big-gist')
				} else {
					jQuery(this).addClass('reveal')
					jQuery(this).addClass('small-gist')
				}
			})
		}
	}, 1000);

});
