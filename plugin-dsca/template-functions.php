<?php
/**
 * Get the featured image
 *
 * @param [type] $id
 * @return void
 */
function get_dsca_featured_image( $id = null, $size = 'full' ) {
	$id = ! $id ? get_the_ID() : intval( $id );
	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), $size );
	if ( isset( $img[1] ) ) {
		$alt = get_the_title( $id );
		$img = "<img src='{$img[0]}' alt=\"{$alt}\" class='dsca_featured_image' />";
		if ( ! is_single() ) {
			$img = "<a href='".get_permalink($id)."' class='noborder'>".$img."</a>";
		}
		return $img;
	}
}

/**
 * Get the featured image
 *
 * @param [type] $id
 * @return void
 */
function dsca_featured_image( $id = null, $size = 'full' ) {
	echo get_dsca_featured_image( $id, $size );
}