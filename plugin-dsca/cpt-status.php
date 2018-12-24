<?php
/**
 * Custom Post Type: STATUS
 *
 * @package dsca
 */

/**
 * Register custom post type STATUS
 */
add_action('init', function () {
	$cpt_name = 'Status';
	$cpt_slug = 'status';
	$args = [
		'labels' => dsca_make_labels( $cpt_name ),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-megaphone',
		'supports' => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
		'show_in_rest' => true,
		'rest_base' => $cpt_slug,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
	];
	register_post_type( $cpt_slug, $args );
});

// status - change title to excerpt of post_content
add_action('save_post', function ( $post_id = '' ) {
	if ( 'status' === get_post_type( $post_id ) ) {
		$ramble    = get_post( $post_id );
		$new_title = trim( substr( wp_strip_all_tags( nl2br( $ramble->post_content ) ), 0, 50 ) );
		$length    = strlen( $ramble->post_content );

		if ( $length > 50 )
			$new_title .= '...';

		if ( $new_title !== $ramble->post_title ) {
			$new_slug = sanitize_title( substr( wp_strip_all_tags( $ramble->post_content ), 0, 50 ) );

			$myp               = array();
			$myp['ID']         = $ramble->ID;
			$myp['post_title'] = $new_title;
			$myp['post_name']  = $new_slug;
			$myp['guid']       = str_replace( $ramble->name, $new_slug, $ramble->guid );
			wp_update_post($myp);
		}
	}
});

add_action('the_title_rss', function ($title) {
	if ('status' === get_post_type() && is_feed()) {
		$parts = explode(' ', $title);
		return $parts[0];
	}
	return $title;
});
