<?php

/**
 * STATUS remove title from RSS feed.
 */
add_filter('the_title_rss', 'dsca_fix_post_format_status_titles', 10, 2 );

function dsca_fix_post_format_status_titles( $title, $id ) {
	if ( 'status' === get_post_format() && $id === get_the_ID()) {
		return get_the_date() . ' Status';
	}
	return $title;
}

// Disable comments on STATUS posts
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

// add_filter('wp_title', function ( $title ) {
// 	//if (  && $id === get_the_ID()) {
// 		//return get_the_date() . ' Status';
// 	//}
// 	if ( is_singular( 'post' ) && 'status' === get_post_format() ) {
// 		return "hi";
// 	}
// 	return get_theID().$title;
// }, 10, 2 );