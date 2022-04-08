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



add_action('wp_head', function() {

	if ( 'Twenty Fifteen' !== wp_get_theme()->get('Name') )
		return;

	?>
	<style>
.social-navigation a[href*="stackexchange.com"]:before {
	content: "";
	background: url(<?= dsca_get_plugin_uri() ?>/assets/icon-stack-exchange.png) 30px 30px;
	background-position: center;
	background-size: contain;
	width: 28px;
	height: 28px;
	display: inline-block;
	transform: translateX(-1px) translateY(-3px);
	opacity: 0.8;
}

.social-navigation li:hover a[href*="stackexchange.com"]:before {
	opacity: 0.6;
}
		</style>
	<?
});
