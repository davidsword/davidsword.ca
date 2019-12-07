<?php
/**
 * Overwrite Tags with hierachial type instead.
 *
 * @package davidsword-ca
 */


function dsca_hierarchical_tags() {
	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name' ),
		'menu_name'                  => __( 'Tags' ),
		'all_items'                  => __( 'All Tags' ),
		'parent_item'                => __( 'Parent Tag' ),
		'parent_item_colon'          => __( 'Parent Tag:' ),
		'new_item_name'              => __( 'New Tag Name' ),
		'add_new_item'               => __( 'Add New Tag' ),
		'edit_item'                  => __( 'Edit Tag' ),
		'update_item'                => __( 'Update Tag' ),
		'view_item'                  => __( 'View Tag' ),
		'separate_items_with_commas' => __( 'Separate tags with commas' ),
		'add_or_remove_items'        => __( 'Add or remove tags' ),
		'choose_from_most_used'      => __( 'Choose from the most used' ),
		'popular_items'              => __( 'Popular Tags' ),
		'search_items'               => __( 'Search Tags' ),
		'not_found'                  => __( 'Not Found' ),
	);

	// Override structure of built-in WordPress tags
	register_taxonomy( 'post_tag', 'post', array(
		'hierarchical'              => true, // eaiser to check a box than remeber tag.
		'query_var'                 => 'tag',
		'labels'                    => $labels,
		'public'                    => false, // intentionally not public, internal tags.
		'show_ui'                   => true,
		'show_in_rest'              => true,
		'show_admin_column'         => true,
		'_builtin'                  => true,
	) );
}

add_action('init', 'dsca_hierarchical_tags');
