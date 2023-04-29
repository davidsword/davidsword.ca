<?php

add_action('rest_api_init', 'mm');
add_action('init', 'mm');

function mm(){
	
	// toggle with option, eaiser than code.
	$mm = get_option('mm', 'notyetset');

	// so its editable in /wp-admin/options.php
	if ( 'notyetset' === $mm )
		add_option('mm','0');

	if ( '0' === $mm )
		return;

	if( is_user_logged_in() || is_admin() )
		return;
	
	if ( defined('WP_CLI') && WP_CLI )
		return;

	if( is_login_page() )
		return;

	if( ! headers_sent() ){
		header('X-Robots-Tag', 'noindex, nofollow, noarchive');
	}

	add_filter( 'xmlrpc_enabled', '__return_false' );
	
	if ( file_exists(__DIR__.'/../assets/splash.html') ) {
		include(__DIR__.'/../assets/splash.html');
	} else {
		header("503 Site Unavailable", true, 503);
		header('Retry-After: 2592000'); // maybe next month 🤷
		echo esc_html( "".$_SERVER['SERVER_NAME'] );
	}
	die;
}

function is_login_page() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'), true);
}
