<?php

// don't show private when logged in on front end
add_filter('pre_get_posts', function( $query ) {
	if ( is_admin() )
		return;
	$query->set('post_status', 'publish');
}, 999);