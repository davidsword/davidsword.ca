/* eslint-disable */
jQuery(document).ready(function() { // executes when HTML-Document is loaded and DOM is ready

	// remove "SHOW MORE" on small GISTS
	if (jQuery('html body .oembed-gist')) {
		jQuery('html body .oembed-gist').click(function(){
			jQuery(this).addClass('reveal');
		})
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