<?php
/**
 * Functions for this theme.
 *
 * See README.TXT for theme doc.
 *
 * @package davidsword-2018
 */

defined( 'ABSPATH' ) || exit;

/**
 * The davidsword.ca plugin.
 *
 * Regardless of theme, this functionality is carried over.
 * Storing in theme since all my themes will be custom and centeralized codebase is eaiser.
 */
require 'plugin-dsca/index.php';

/**
 * Add various features for theme
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'custom-logo', [
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => [ 'site-title', 'site-description' ],
	]);
	add_theme_support( 'post-thumbnails', [ 'post', 'page' ] );
	add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ] );

	// gutenberg.
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	// Create colour palette for gutenberg.
	$my_colours = [ '#333', '#fff', '#999', '#4d77e2', '#fc6f56', '#ffe454', '#e279d0', '#6ba9df', '#d27070', '#6dbdac', '#7b82bd', '#B98EFF', '#8aa2ff' ];
	$palette    = [];
	foreach ( $my_colours as $colour ) {
		$palette[] = [ 'color' => $colour ];
	}
	add_theme_support( 'editor-color-palette', $palette );

});

// Navigation.
register_nav_menu( 'main-nav', 'Main Navigation' );
register_nav_menu( 'sec-nav',  'Secondary Navigation' );

/**
 * Enqueue scripts into WordPress.
 *
 * Load in various styles and scripts into WordPress. Run conditionals to reduce unneeded scripts.
 *
 * @since 1.0.0
 *
 * @see `add_action( 'wp_enqueue_scripts'...`
 */
add_action( 'wp_enqueue_scripts', function () {

	$is_localhost = ( 'vvv.davidswor' === $_SERVER['HTTP_HOST'] );
	$ver = ( WP_DEBUG || $is_localhost ) ? time() : wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'swrdbs_js',
		get_template_directory_uri() . '/assests/js/index.js',
		[ 'jquery' ],
		$ver,
		true
	);

	wp_enqueue_style(
		'main',
		get_template_directory_uri() . '/style.css',
		[],
		$ver
	);
});

/**
 * Enquque Editor Script
 *
 * Just for gutenberg. Compiled with Grunt.
 *
 * @see assests/css/style-editor.less
 */
add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_style(
		'dsca-editor-css',
		get_template_directory_uri() . '/assests/css/style-editor.css',
		[ 'wp-edit-blocks' ],
		time()
	);
}, 99 );


/**
 * Chop the length of a string without breaking word.
 *
 * Only chops if string is > chop length.
 *
 * Used only in search,php
 *
 * @param  string  $string of content to possibly chop.
 * @param  integer $choplen the point at which we want to chop.
 * @param  string  $cut what we replaced the chopped off value with.
 * @return string  possibly chopped content
 */
function _return_chopstring( $string, $choplen = 20, $cut = '...' ) {
	if ( strlen( $string ) > $choplen ) {
		$ashortertitle = wp_strip_all_tags( $string );

		$first     = substr_replace( $ashortertitle, '', ( floor( $choplen / 2 ) ), strlen( $ashortertitle ) );
		$second    = substr_replace( $ashortertitle, '', 0, ( strlen( $ashortertitle ) - ( floor( $choplen / 2 ) ) ) );
		$newstring = $first . $cut . $second;

		// if the cut only cut 1 letter.. we don't want to bother. at least 4 had to be cut.
		return ( strlen( $newstring ) > ( strlen( $string ) ) ) ? $string : $newstring;
	} else {
		return $string;
	}
}
