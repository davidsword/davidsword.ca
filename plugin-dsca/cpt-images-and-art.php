<?php
/**

 */

add_action('init', function () {
	$cptName = 'Images';
	$cptSlug = 'images';
	$args = [
		'labels' => dsca_make_labels($cptName),
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
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
		'rest_base' => $cptSlug,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
	];
	register_post_type($cptSlug, $args);
});

add_action('init', function () {
	$cptName = 'art';
	$cptSlug = 'art';
	$args = [
		'labels' => dsca_make_labels($cptName),
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
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
		'rest_base' => $cptSlug,
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'exclude_from_search' => true
	];
	register_post_type($cptSlug, $args);
});




// if it's an image for the image section,
// create post and assign category and date from file name
// when we upload a media item
add_filter( 'add_attachment', function ($attachment_id) {
	$attachment = get_post($attachment_id);
	$att_title = $attachment->post_title;
	if( !preg_match("/^([0-9-]{8}|[0-9-]{10,11})$/i", $att_title) ) return;
	// get the attachments filename, build date
	$post_date = date('Y-m-d H:i:s',strtotime($att_title." 00:00:01"));
	$gmt_offset = get_option( 'gmt_offset' ) * 3600;
	$post_date_gmt = date('Y-m-d H:i:s',(strtotime($att_title." 00:00:01") + $gmt_offset ));
	// create our new post
	$myp = array();
	$myp['post_type']  = 'images';
	$myp['post_title'] 		= $att_title;
	$myp['post_date'] 		= $post_date;
	$myp['post_date_gmt'] 	= $post_date_gmt;
	$myp['post_status']     = 'publish';
	$myp['comment_status']  = 'closed';
	$newid = wp_insert_post($myp);
	// set upload media as thumbnail to new post
	if ($newid)
		set_post_thumbnail( $newid, $attachment->ID );
}, 10, 2 );



add_action('the_excerpt_rss', function ($content) {
	if (isset($_GET['post_type']) && $_GET['post_type'] == 'images') {
		$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "large");
		$content .= "<img src='{$img[0]}' />";
	}
	// if (is_feed()) {
	// 	$content .= "<br /><br /><a href='".get_permalink()."'>".get_permalink()."</a>";
	// }
	return $content;
});


// set limit on front end main archive page
add_filter('pre_get_posts', function ($query) {
	// ONLY ON FRONT END ARCHIVES PAGE
	if (!is_admin() &&
		isset($query->query['post_type']) && ($query->query['post_type'] == 'images' || $query->query['post_type'] == 'art') &&
		$query->is_archive == 1 &&
		!isset($query->query['posts_per_page']))
		$query->set('posts_per_page', '24');

		// ONLY ON FRONT END ARCHIVES PAGE
	if (!is_admin() &&
		isset($query->query['post_type']) && ($query->query['post_type'] == 'projects') &&
		$query->is_archive == 1 &&
		!isset($query->query['posts_per_page']))
		$query->set('posts_per_page', '6');

	return $query;
});

/**
 * Prevent single pages for STATUS and IMAGE cpts
 */
add_action('wp', function () {
	if (!is_admin() && is_singular(['images', 'art'])) {
		wp_safe_redirect(get_post_type_archive_link(get_post_type()));
		exit;
	}
});
