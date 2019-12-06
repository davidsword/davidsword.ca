<?php
/**
 * Set post_formats at the Category level instead of the POST level.
 *
 * When all posts in a specific category have the same format, marking it as such
 * is redundant. This plugin instead allows setting post_formats at the category
 * so all posts therein will have the format set.
 *
 * @todo posts with multiple categories that have conflicting formats (use primary)
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

/**
 * STATUS remove title from RSS feed.
 */
add_filter('the_title_rss', function ( $title ) {
	if ( 'status' === dsca_get_pseduo_post_format() ) {
		return get_the_date();
	}
	return $title;
}, 10, 1 );

/**
 * Add fake title for Search results and in admin.
 */
add_filter('the_title', function ( $title, $id ) {
	if ( ! is_admin() && get_the_ID() === $id && 'status' === dsca_get_pseduo_post_format( $id ) ) {
		return get_the_date();
	}
	return $title;
}, 10, 2 );

/**
 * Add fake title for <title> tag.
 */
add_filter('wp_title', function ( $title ) {
	if ( ! is_admin() && is_singular() ) {
		$id = get_the_ID();
		if ( 'status' === dsca_get_pseduo_post_format( $id ) ) {
			return get_the_date()." ".$title;
		}
	}
	return $title;
}, 999 );

/**
 * Get Pseduo post format of post.
 *
 * Must be used inside the loop.
 *
 * @return mixed string of post format or false if not a Pseduo post format.
 */
function dsca_get_pseduo_post_format( $id = null ) {
	if ( dsca_is_pseduo_post_format_status( $id ) )
		return 'status';
	if ( dsca_is_pseduo_post_format_image( $id ) )
		return 'image';
	return 'standard';
}

/**
 * Check if post is Pseduo post format IMAGE.
 */
function dsca_is_pseduo_post_format_image( $id = null ) {
	if ( ! $id ) {
		global $post; // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'post';
	} else {
		$get_post = get_post( $id ); // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'get_post';
	}
	return ( ! empty( ${$source}->post_title ) && empty( ${$source}->post_content ) );
}

/**
 * Check if post is Pseduo post format STATUS.
 */
function dsca_is_pseduo_post_format_status( $id = null ) {
	if ( ! $id ) {
		global $post; // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'post';
	} else {
		$get_post = get_post( $id ); // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'get_post';
	}
	return empty( ${$source}->post_title );
}
