<?php
/**
 * For IMAGEs and ART custom post types
 *
 * @package dsca
 */

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
	$myp['post_type']      = 'post';
	$myp['post_title']     = $att_title;
	$myp['post_date']      = $post_date;
	$myp['post_date_gmt']  = $post_date_gmt;
	$myp['post_status']    = 'publish';
	$myp['comment_status'] = 'closed';
	$newid                 = wp_insert_post( $myp );

	// set upload media as thumbnail to new post.
	if ( $newid ) {
		set_post_thumbnail( $newid, $attachment->ID );
		add_post_meta( $newid, 'dsca_migrated_from', 'images' );
		set_post_format( $newid , 'image' );
		wp_add_object_terms( $apost->ID, 'image', 'category' );
	}
}, 10, 2 );


/**
 * if IMAGE and is rss feed: include Featured Image
 * @TODO fix this.
 */
add_action('the_excerpt_rss', function ( $cnt ) {
	// if ( isset( $_GET['post_type'] ) && 'images' === $_GET['post_type'] ) {
		// $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
		// $cnt .= "<img src='{$img[0]}' />";
	// }
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
 *
 * @TODO fix this.
 */
add_filter('pre_get_posts', function ( $query ) {

	// $is_img = ( isset( $query->query['post_type'] ) && in_array( $query->query['post_type'], [ 'images', 'art' ], true ) );
	// $is_archive = ( $query->is_archive == 1 );
//
	// ONLY ON FRONT END ARCHIVES PAGE.
	// if ( ! is_admin() && $is_img && $is_archive && ! isset( $query->query['posts_per_page'] ) ) {
		// $query->set( 'posts_per_page', '24');
	// }

	return $query;
});

/**
 * Prevent single pages for STATUS and IMAGE cpts
 *
 * @TODO
 */
add_action('wp', function () {
	// if ( ! is_admin() && is_singular( [ 'images', 'art' ] ) ) {
		// wp_safe_redirect( get_post_type_archive_link( get_post_type() ) );
		// exit;
	// }
});
