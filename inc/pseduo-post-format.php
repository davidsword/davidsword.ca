<?php
/**
 * Tweaks to integrate a fake post format `status` and `image`
 *
 * @TODO these extend the functionality of WordPress and should likely be a plugin.
 *
 * @package davidsword-ca
 */

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
	if ( ! is_admin() && get_the_ID() == $id && 'status' === dsca_get_pseduo_post_format( $id ) ) {
		return get_the_date();
	}
	return $title;
}, 10, 2 );

/**
 * Add fake title for <title> tag.
 */
add_filter('wp_title', function ( $title ) {
	if ( ! is_admin() && is_singular() ) {
		global $post;
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
	global $post;
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
		global $post;
		$source = 'post';
	} else {
		$get_post = get_post( $id );
		$source = 'get_post';
	}
	return ( ! empty( ${$source}->post_title ) && empty( ${$source}->post_content ) );
}

/**
 * Check if post is Pseduo post format STATUS.
 */
function dsca_is_pseduo_post_format_status( $id = null ) {
	if ( ! $id ) {
		global $post;
		$source = 'post';
	} else {
		$get_post = get_post( $id );
		$source = 'get_post';
	}
	return empty( ${$source}->post_title );
}

/**
 * Disable comments on STATUS posts
 */
// add_action( 'the_post', function() {
	// if ( is_single() && 'status' === dsca_get_pseduo_post_format() ) {
		// add_filter( 'comments_open', function($open, $post_id) {
			// $open = false;
		// }, 10, 2 );
		// add_action('wp_enqueue_scripts', function () {
			// wp_deregister_script( 'comment-reply' );
		// });
	// }
// } );