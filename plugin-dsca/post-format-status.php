<?php

/**
 * STATUS remove title from RSS feed.
 */
add_action('the_title_rss', function ( $title ) {
	if ( 'status' === get_post_format() && is_feed() ) {
		return ''; //
	}
	return $title;
});