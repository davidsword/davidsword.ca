<?php
/**
 * For IMAGEs and ART custom post types
 *
 * @package dsca
 */

/**
 * Register IMAGES
 *
 * This is for sort the "instagram" like posts.
 */
add_action( 'init', function () {
	$cpt_name = 'Images';
	$cpt_slug = 'images';
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
		'menu_icon' => 'dashicons-format-gallery',
		'supports' => [ 'title', 'editor', 'thumbnail' ],
		'show_in_rest' => true,
		'rest_base' => $cpt_slug,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
	];
	register_post_type( $cpt_slug, $args );
});

/**
 * Register ART
 *
 * This is just a copy of IMAGE but for somthing else.
 */
add_action( 'init', function () {
	$cpt_name = 'art';
	$cpt_slug = 'art';
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
		'menu_icon' => 'dashicons-format-gallery',
		'supports' => [ 'title', 'editor', 'thumbnail' ],
		'show_in_rest' => true,
		'rest_base' => $cpt_slug,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
	];
	register_post_type( $cpt_slug, $args );
});

/**
 * Automatically Create post when uploading IMAGE post
 *
 * All files are named YYYYMMDD{-##}.jpg, so "listen" for files like that
 * being uploaded to Media Library. When one is seen create post and assign category
 * and date from file name.
 */
add_filter( 'add_attachment', function ( $attachment_id ) {

	// get the current image uploaded.
	$attachment = get_post( $attachment_id );
	$att_title = $attachment->post_title;

	// winner winner chicken dinner?
	if ( ! preg_match( '/^([0-9-]{8}|[0-9-]{10,11})$/i', $att_title ) ) {
		return;
	}
	// get the attachments filename, build date.
	$post_date     = date( 'Y-m-d H:i:s', strtotime( $att_title . " 00:00:01" ) );
	$gmt_offset    = get_option( 'gmt_offset' ) * 3600;
	$post_date_gmt = date( 'Y-m-d H:i:s', ( strtotime( $att_title . " 00:00:01" ) + $gmt_offset ) );

	// create our new post.
	$myp                   = [];
	$myp['post_type']      = 'images';
	$myp['post_title']     = $att_title;
	$myp['post_date']      = $post_date;
	$myp['post_date_gmt']  = $post_date_gmt;
	$myp['post_status']    = 'publish';
	$myp['comment_status'] = 'closed';
	$newid                 = wp_insert_post( $myp );

	// set upload media as thumbnail to new post.
	if ( $newid ) {
		set_post_thumbnail( $newid, $attachment->ID );
	}
}, 10, 2 );


/**
 * if IMAGE and is rss feed: include Featured Image
 */
add_action('the_excerpt_rss', function ( $cnt ) {
	if ( isset( $_GET['post_type'] ) && 'images' === $_GET['post_type'] ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
		$cnt .= "<img src='{$img[0]}' />";
	}
	// if (is_feed()) {
	// 	$cnt .= "<br /><br /><a href='".get_permalink()."'>".get_permalink()."</a>";
	// }
	return $cnt;
});


/**
 * Set limit on front end main archive page.
 *
 * We're tiling the images on output, 4 columns, so we need to set the
 * per page to a multiple of that.
 */
add_filter('pre_get_posts', function ( $query ) {

	$is_img = ( isset( $query->query['post_type'] ) && in_array( $query->query['post_type'], [ 'images', 'art' ], true ) );
	$is_archive = ( $query->is_archive == 1 );

	// ONLY ON FRONT END ARCHIVES PAGE.
	if ( ! is_admin() && $is_img && $is_archive && ! isset( $query->query['posts_per_page'] ) ) {
		$query->set( 'posts_per_page', '24');
	}

	return $query;
});

/**
 * Prevent single pages for STATUS and IMAGE cpts
 */
add_action('wp', function () {
	if ( ! is_admin() && is_singular( [ 'images', 'art' ] ) ) {
		wp_safe_redirect( get_post_type_archive_link( get_post_type() ) );
		exit;
	}
});
