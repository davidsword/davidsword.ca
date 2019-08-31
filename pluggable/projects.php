<?php
/**
 * Custom page for PROJECTs post type.
 *
 * @package davidsword-ca
 */

/**
 * Register post type
 */
add_action( 'init' , function () {
	$cpt_name = 'Project';
	$cpt_slug = 'project';
	$args = [
		'labels'                => dsca_make_labels( $cpt_name ),
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'query_var'             => true,
		'rewrite'               => true,
		'has_archive'           => 'projects',
		'capability_type'       => 'post',
		'hierarchical'          => false,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book',
		'supports'              => [
			'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'
		],
		'show_in_rest'          => true,
		'rest_base'             => 'projects',
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

	$is_project = isset( $query->query['post_type'] ) && 'project' === $query->query['post_type'];
	$is_archive = ( 1 == $query->is_archive );

	// ONLY ON FRONT END ARCHIVES PAGE.
	if ( ! is_admin() && $is_project && $is_archive && ! isset( $query->query['posts_per_page'] ) ) {
			$query->set( 'posts_per_page', '-1' );
	}

	return $query;
});

/**
 * Add custom tags for Projects
 *
 * Filter out different types of projects.
 */
add_action( 'init', function () {
	$tax_name = 'Flag';
	$tax_slug = 'flag';
	register_taxonomy( $tax_slug, [ 'project' ], [
		'hierarchical' => false,
		'labels' => [
			'name' => $tax_name, 'taxonomy general name',
			'singular_name' => $tax_name, 'taxonomy singular name',
			'search_items' =>  'Search '.$tax_name.'s',
			'all_items' => 'All '.$tax_name.'s',
			'parent_item' => 'Parent ' . $tax_name,
			'parent_item_colon' => 'Parent '.$tax_name.':',
			'edit_item' => 'Edit '.$tax_name,
			'update_item' => 'Update '.$tax_name,
			'add_new_item' => 'Add New '.$tax_name,
			'new_item_name' => 'New '.$tax_name,
			'menu_name' => $tax_name,
		],
		'show_ui' => true,
		'public' => false,
		'query_var' => false,
		'rewrite' => [ 'slug' => '' ],
		'show_in_quick_edit' => true
	]);
}, 0 );

/**
 * Add the Flag in the admin
 */
add_filter( 'manage_projects_posts_columns', function( $columns ) {
	$columns['flag'] = 'Flag';
	return $columns;
} );

/**
 * Display the Flag value in the admin
 */
add_action('manage_posts_custom_column', function ( $column_name, $id ) {
	if ( 'flag' === $column_name ) {
		$flag = dsca_get_flag( $id );
		if ( false !== $flag ) {
			echo $flag;
		}
	}
}, 999, 2);

/**
 * Helper function to get the Projects FLAG tax
 *
 * Designed to only get one flag intentionally.
 *
 * @param int     $post_id of current post to get flag for.
 * @param boolean $only_slug true to only receive string of slug, false to get html.
 *
 * @return string|boolean string of slug or false if no flag
 */
function dsca_get_flag( $post_id = false, $only_slug = false ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$flags = get_the_terms( $post_id, 'flag' );
	if ( is_array( $flags ) ) {
		$flag = array_pop( $flags );
		return $only_slug ? $flag->slug : "<span class='gray'>#{$flag->slug}</span>";
	}
	return false;
}

/**
 * Add projects to main RSS feed.
 *
 * This may cause a bug in the future if anything else edits this.
 *
 * @param $qv array
 * @return array
 */
add_filter('request', function ( $qv ) {
	if ( isset( $qv['feed'] ) ) {
		if ( ! isset( $qv['post_type'] ) ) {
			$qv['post_type'] = [ 'post', 'project' ];
		}
	}
	return $qv;
} );

/**
 * Allow featured image.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails', [ 'project' ] );
});

/**
 * Dynamically Generate Labels for cpts admin interface.
 *
 * I'm really not sure why core doesn't do this.
 *
 * @TODO abstracting this is no longer needed w/ just one post type.
 *
 * @param string $cpt name of the CPT, singular.
 * @return array of labels
 */
function dsca_make_labels( $cpt ) {
	return [
		'name'               => $cpt,
		'singular_name'      => $cpt,
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New ' . $cpt,
		'edit_item'          => 'Edit ' . $cpt,
		'new_item'           => 'New ' . $cpt,
		'all_items'          => 'All ' . $cpt,
		'view_item'          => 'View ' . $cpt,
		'search_items'       => 'Search ' . $cpt,
		'not_found'          => 'No ' . $cpt . ' found',
		'not_found_in_trash' => 'No ' . $cpt . ' found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => $cpt,
	];
}