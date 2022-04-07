<?php

add_filter( 'body_class', function( $classes  ) {
	$classes[] = sanitize_key(wp_get_theme()->get('Name'));
	return $classes;
}, 10, 3 );
