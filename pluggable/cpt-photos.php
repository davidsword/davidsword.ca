<?php

/**
 * Register post type
 */
add_action( 'init' , function () {
	$cpt_name = 'Photos';
	$cpt_slug = 'photo';
	$args = [
		'labels'                => dsca_make_labels( $cpt_name ),
		'public'                => false,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'query_var'             => false,
		'rewrite'               => false,
		'has_archive'           => $cpt_slug,
		'capability_type'       => 'post',
		'hierarchical'          => false,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-images-alt2',
		'supports'              => [
			'title', 'editor', 'author', 'thumbnail' ,// 'excerpt', 'comments'
		],
		'show_in_rest'          => true,
		'taxonomies'            => [ 'category' ],
		//'rest_base'             => 'projects',
		//'rest_controller_class' => 'WP_REST_Posts_Controller',

	];
	register_post_type( $cpt_slug, $args );
});
