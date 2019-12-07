<?php
/**
 * Add on to PROJECT category.
 *
 * @package davidsword-ca
 */

/**
 * Add custom tags for Projects
 *
 * Filter out different types of projects.
 */
add_action( 'init', function () {
	$tax_name = 'Flag';
	$tax_slug = 'flag';
	register_taxonomy( $tax_slug, [ 'post' ], [
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
		'show_in_rest' => true,
		'query_var' => false,
		'rewrite' => [ 'slug' => '' ],
		'show_in_quick_edit' => true
	]);
}, 0 );

/**
 * Add the Flag in the admin
 */
add_filter( 'manage_post_posts_columns', function( $columns ) {
	$columns['flag'] = 'Project Flag';
	return $columns;
} );

/**
 * Display the Flag value in the admin
 */
add_action('manage_posts_custom_column', function ( $column_name, $id ) {
	if ( 'flag' === $column_name ) {
		$flag = dsca_get_flag( $id );
		if ( false !== $flag ) {
			echo wp_kses_post( $flag );
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
