<?php
/**
 * Tweaks to integrate the `status` post format slightly different than normal.
 *
 * @TODO these extend the functionality of WordPress and should likely be a plugin.
 *
 * @package davidsword-ca
 */

/**
 * STATUS remove title from RSS feed.
 */
add_filter('the_title_rss', function ( $title, $id ) {
	if ( 'status' === get_post_format() && $id === get_the_ID()) {
		return get_the_date() . ' Status';
	}
	return $title;
}, 10, 2 );

/**
 * Disable comments on STATUS posts
 */
add_action( 'the_post', function() {
	if ( is_single() && 'status' === get_post_format() ) {
		add_filter( 'comments_open', function($open, $post_id) {
			$open = false;
		}, 10, 2 );
		add_action('wp_enqueue_scripts', function () {
			wp_deregister_script( 'comment-reply' );
		});
	}
} );

/**
 * Add fake title for Search results and in admin.
 */
add_filter('the_title', function ( $title, $id ) {
	if ( get_the_ID() == $id && 'status' === get_post_format( $id ) ) {
		return get_the_date()." Status Update";
	}
	return $title;
}, 10, 2 );

/**
 * Add fake title for <title> tag.
 */
add_filter('wp_title', function ( $title ) {
	if ( is_singular() ) {
		global $post;
		$id = get_the_ID();
		if ( 'status' === get_post_format( $id ) ) {
			return get_the_date()." Status Update ".$title;
		}
	}
	return $title;
}, 999 );