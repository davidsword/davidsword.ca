<?php

// add all post types to main RSS feed.
add_filter('request', function ( $qv ) {
	if ( isset( $qv['feed'] ) ) {
		$qv['post_type'] = [ 'post', 'images', 'projects', 'status' ];
	}
	return $qv;
} );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails' , ['images' , 'projects', 'status'] );
});

add_action('the_excerpt_rss',function($content){
	if (isset($_GET['post_type']) && $_GET['post_type'] == 'images') {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), "large" );
		$content .= "<img src='{$img[0]}' />";
	}
	if (is_feed()) {
		$content .= "<br /><br /><a href='".get_permalink()."'>".get_permalink()."</a>";
	}
	return $content;
});

add_action('the_title_rss', function ($title) {
	if ( 'status' === get_post_type() && is_feed() ) {
		$parts = explode( ' ', $title );
		return $parts[0];
	}
	return $title;
});

add_filter('manage_art_posts_columns', 'ds_makethumbnailcol');
add_filter('manage_images_posts_columns', 'ds_makethumbnailcol');
add_filter('manage_projects_posts_columns', 'ds_makethumbnailcol');
function ds_makethumbnailcol($columns){
	unset($columns['date']);
	unset($columns['comments']);
	unset($columns['author']);
	$columns['img_thumbnail'] = '';
	return $columns;
}

add_action('manage_posts_custom_column',function ($column_name,$id){
	 if ($column_name == 'img_thumbnail') {
		  echo "<a href='".get_edit_post_link()."'>";
		  echo the_post_thumbnail( 'thumbnail' , array('style' => 'max-width: 40px;height:auto') );
		  echo "</a>";
	}
},999,2);


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




// status - change title to excerpt of post_content
add_action( 'save_post', function ( $post_id = '') {
	if (get_post_type($post_id) == 'status') {
		$ramble = get_post($post_id);
		$newTitle = trim(substr(strip_tags(nl2br($ramble->post_content)),0,50));
		if (strlen($ramble->post_content) > 50)
			$newTitle .= "...";
		if ($newTitle != $ramble->post_title) {
			$newSlug = sanitize_title(substr(strip_tags($ramble->post_content),0,50));
			$myp 				= array();
			$myp['ID'] 			= $ramble->ID;
			$myp['post_title'] 	= $newTitle;
			$myp['post_name'] 	= $newSlug;
			$myp['guid'] 		= str_replace($ramble->name, $newSlug, $ramble->guid);
			wp_update_post($myp);
		}
	}
});

// set limit on front end main archive page
add_filter('pre_get_posts', function ($query) {
	global $mycats;
	// ONLY ON FRONT END ARCHIVES PAGE
	if (
		!is_admin() &&
		isset($query->query['post_type']) &&
		($query->query['post_type'] == 'images' || $query->query['post_type'] == 'art') &&
		$query->is_archive == 1 &&
		!isset($query->query['posts_per_page'])
	)
		$query->set( 'posts_per_page', '24' );

		// ONLY ON FRONT END ARCHIVES PAGE
		if (
			!is_admin() &&
			isset($query->query['post_type']) &&
			($query->query['post_type'] == 'projects') &&
			$query->is_archive == 1 &&
			!isset($query->query['posts_per_page'])
		)
		$query->set( 'posts_per_page', '6' );

	return $query;
});

// prevent SINGLE for status and images
add_action('wp',function(){
	if (!is_admin() && is_singular( ['images','art'] )) //'status',
		wp_redirect( get_post_type_archive_link( get_post_type() ) );
});
