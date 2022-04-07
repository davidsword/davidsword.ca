<?php
// davidsword.ca TwentyFifteen Custom CSS
add_action( 'wp_enqueue_scripts', function() {

	if ( 'Twenty Fifteen' !== wp_get_theme()->get('Name') )
		return;

	wp_enqueue_style(
		'change-twentyfifteen-custom-css',
		dsca_get_plugin_uri() . '/assets/twentyfifteen.css',
		array(),
		time(), // no cache.
		false
	);

}, 999999999 );
