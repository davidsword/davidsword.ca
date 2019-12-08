<?php
/**
 * Featured Posts
 *
 * Add a toggle button to show all posts, or just featured posts.
 * Featured posts are the vital few to show off.
 *
 * Basically the 80/20 rule for WordPress blog, toggle to only
 * show the top 20% of your posts.
 *
 * @package davidsword-ca
 */

/**
 * Register custom Metabox.
 */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'dsca-featured-metabox', // the class.
		'Featured Post',
		'dsca_ftr_mb', // the callback.
		'post'
	);
} );

/**
 * Add custom Metabox.
 */
function dsca_ftr_mb( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'dsca_ftr_mb_nonce' );
	$is_featured = (boolean) get_post_meta( get_the_ID(), 'featured', true );
	?>
	Featured: <input type="checkbox" name="featured" value='1' <?php checked( $is_featured )  ?>  />
	<?php
}

/**
 * Save featured metabox value
 */
add_action( 'save_post', function ( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( ! wp_verify_nonce( $_POST['dsca_ftr_mb_nonce'], plugin_basename( __FILE__ ) ) )
		return;
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;

	$is_featued = ( isset( $_POST['featured'] ) && '1' === $_POST['featured'] );

	if ( $is_featued ) {
		update_post_meta( $post_id , 'featured', 1 );
	} else {
		delete_post_meta( $post_id, 'featured' );
	}
});

