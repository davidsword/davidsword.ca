<?php
/**
 * Modify Titles and output based on type of conetnt in post.
 *
 * Instead of assigning a post format, this theme looks at the content and determins the post format:
 *
 * - IMAGE          - has title and featured image, no content
 * - STATUS         - has content, no title
 * - (Default Post) - has everything title, feature image, content, optional excerpt
 *
 * For single status's when no title is present, this theme will create a title of YYYYMMDD.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;

/**
 * STATUS: remove title from RSS feed.
 */
add_filter('the_title_rss', function ( $title ) {
	if ( 'status' === dsca_get_format() ) {
		return get_the_date();
	}
	return $title;
}, 10, 1 );

/**
 * STATUS: Add fake title for Search results and in admin.
 */
add_filter('the_title', function ( $title, $id ) {
	$is_status = 'status' === dsca_get_format( $id );
	if ( ( is_admin() || is_search() ) && get_the_ID() === $id && $is_status ) {
		return get_the_date();
	}
	return $title;
}, 10, 2 );

/**
 * STATUS: Add fake title for <title> tag.
 */
add_filter('wp_title', function ( $title ) {
	if ( ! is_admin() && is_singular() ) {
		$id = get_the_ID();
		if ( 'status' === dsca_get_format( $id ) ) {
			return get_the_date()." ".$title;
		}
	}
	return $title;
}, 999 );

/**
 * IMAGES: remove the title on front end.
 */
add_filter('the_title', function ( $title, $id ) {
	$is_image = 'image' === dsca_get_format( $id );
	if ( ! ( is_admin() || is_search() ) && get_the_ID() === $id && $is_image ) {
		return '';
	}
	return $title;
}, 10, 2 );

// Helper functions:

/**
 * Get the post format of post based on the type of content.
 *
 * Must be used inside the loop.
 *
 * @return string
 */
function dsca_get_format( $id = null ) {
	if ( dsca_is_status( $id ) )
		return 'status';
	if ( dsca_is_image( $id ) )
		return 'image';
	return 'standard';
}

/**
 * Check if post is content resembles a IMAGE post format.
 */
function dsca_is_image( $id = null ) {
	if ( ! $id ) {
		global $post; // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'post';
	} else {
		$get_post = get_post( $id ); // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'get_post';
	}
	return ( empty( ${$source}->post_content ) );
}

/**
 * Check if post is content resembles a STATUS post format.
 */
function dsca_is_status( $id = null ) {
	if ( ! $id ) {
		global $post; // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'post';
	} else {
		$get_post = get_post( $id ); // phpcs:ignore WordPressVIPMinimum.Variables.VariableAnalysis.UnusedVariable
		$source = 'get_post';
	}
	return empty( ${$source}->post_title );
}
