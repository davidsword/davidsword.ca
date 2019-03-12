<?php
/**
 * Get the featured image
 *
 * @param [type] $id
 * @return void
 */
function get_ftr_img( $id = null, $size = 'full' ) {
	$id = ! $id ? get_the_ID() : intval( $id );
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );
	if ( isset( $img[1] ) ) {
		$alt = get_the_title( $id );
		return "<img src='{$img[0]}' alt=\"{$alt}\" class='ftr_img' />";
	}
}

/**
 * Get the featured image
 *
 * @param [type] $id
 * @return void
 */
function ftr_img( $id = null, $size = 'full' ) {
	echo get_ftr_img( $id, $size );
}