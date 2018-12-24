<?php
/**
 * Custom page for PROJECTs post type
 *
 * @package dsca
 */

/**
 * Register post type
 */
add_action( 'init' , function () {
	$cpt_name = 'Projects';
	$cpt_slug = 'projects';
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
		'menu_icon' => 'dashicons-book',
		'supports' => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
		'show_in_rest' => true,
		'rest_base' => 'projects',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	];
	register_post_type( $cpt_slug, $args );
});

/**
 * Set limit on front end main archive page.
 *
 * Projects are a big deal, and older projects aren't that great.
 * So reduce to just show 6 initally.
 */
add_filter('pre_get_posts', function ( $query ) {

	$is_project = isset( $query->query['post_type'] ) && 'projects' === $query->query['post_type'];
	$is_archive = ( 1 == $query->is_archive );

	// ONLY ON FRONT END ARCHIVES PAGE.
	if ( ! is_admin() && $is_project && $is_archive && ! isset( $query->query['posts_per_page'] ) ) {
			$query->set( 'posts_per_page', '6' );
	}

	return $query;
});
