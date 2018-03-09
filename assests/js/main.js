jQuery(document).ready(function() { // executes when HTML-Document is loaded and DOM is ready

	if (jQuery('body').hasClass('single-projects')) {
		jQuery('.menu-item-object-projects').addClass('current-menu-item');
	}

	if (jQuery('body').hasClass('post-type-archive-images')) {
		jQuery('.menu-item-4707').addClass('current-menu-item');
	}

	if (jQuery('body').hasClass('single-post')) {
		jQuery('.current_page_parent').addClass('current-menu-item');
	}

	/* WAYPOINTS banner change ---------------------------------- */
	setTimeout(swrdbs_init_waypoint, 500);
	function swrdbs_init_waypoint() {
	   var waypoints = jQuery('#trigger1').waypoint({
	     handler: function(direction) {
		    if (direction == 'down')
			    jQuery('body').addClass('smaller');
		    else
			    jQuery('body').removeClass('smaller');
	     }
	   });
    }


	// WORDPRESS turn inline MORE links into buttons ----------------------------------
	if (jQuery('.more-link').length > 0)
		jQuery('.more-link').each(function(){ jQuery(this).addClass('.button'); });


	// CLICK hero ARROW ----------------------------------
	if (jQuery('.downarrow').length > 0) {
		jQuery('.downarrow').click(function(){
			var scroll_to = jQuery('main');
			jQuery('html,body').animate(  {scrollTop: (jQuery(scroll_to).offset().top - jQuery('header#head').height())}, 1000  );
			return false;
		});
	}


	// FIRE LIGHTBOX ----------------------------------
	// if (jQuery('.grid.images').length > 0) {
	// 	jQuery('.grid.images a').each(function(index){
	// 		jQuery(this).attr('data-lightbox','image_gallery');
	// 	});
	// }
	if (jQuery('.grid.images')) {
		const gallery = jQuery('.grid.images a[data-lightbox]').featherlightGallery({
	        previousIcon: '&#9664;',
	        nextIcon: '&#9654;',
	        galleryFadeIn: 300,
	        galleryFadeOut: 300
	    });
    }



	// GRAVITY FORMS: Labels -> Placeholders ----------------------------------
	jQuery('footer form .gform_body > ul > li').each(function(index) {
		if ( ! jQuery(this).children().hasClass('ginput_container_checkbox')   ) {
			var feildname = jQuery(this).find('label').text().replace('*','');
			if (jQuery(this).find("textarea"))
				jQuery(this).find("textarea").attr('placeholder',feildname);
			if (jQuery(this).find("input"))
				jQuery(this).find("input").attr('placeholder',feildname);
			jQuery(this).find('label').remove()
		}
	})



	// GRAVITY FORMS: Hide Submit Button ----------------------------------
	/* jQuery('.gform_wrapper input').focus(function() {
		jQuery('#'+jQuery(this).closest('form').attr('id')+' .gform_footer').show();
	}) */



	// NAVIGATION: HOVER  ----------------------------------
	jQuery('nav>ul>li>ul>li>a').hover(
		function() { jQuery(this).parent().parent().parent().addClass('hovering'); },
		function() { jQuery(this).parent().parent().parent().removeClass('hovering'); }
	);
	jQuery('nav>ul>li>ul>li>ul>li>a').hover(
		function() { jQuery(this).parent().parent().parent().parent().parent().addClass('hovering'); },
		function() { jQuery(this).parent().parent().parent().parent().parent().removeClass('hovering'); }
	);




/* =====================================================================================================
   /* !RESIZE FUNCTION - run things when resize window */
/* ----------------------------------------------------------------------------------------------------- */
    function swrdbs_resize() {

        /* MIDDLE ME ---------------------------------- */
		jQuery('.middleme').each(function(){
			var heightofself = jQuery(this).height();
			var heightofparent = jQuery(this).parent().height();
			var dif = Math.floor(((heightofparent) / 2) - (heightofself/2) );
			jQuery(this).css('margin-top',dif+'px');
		});

    }
    // go go go
    swrdbs_resize();
    setTimeout(swrdbs_resize, 1000); // just incase

    // wait for window resizing to finish, then resize function
    jQuery(window).bind('resizeEnd', function() {
        swrdbs_resize();
    });
    jQuery(window).resize(function() {
        if(this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function() {
            jQuery(this).trigger('resizeEnd');
        }, 500);
    });




});
jQuery(window).load(function() { // executes when complete page loaded, including all frames, objects and images

});
