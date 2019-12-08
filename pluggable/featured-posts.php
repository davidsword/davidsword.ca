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
 *
 * @todo make this prettier.
 */
function dsca_ftr_mb( $post ) {
	wp_nonce_field( plugin_basename( __FILE__ ), 'dsca_ftr_mb_nonce' );
	$is_featured = (boolean) get_post_meta( get_the_ID(), 'featured', true );
	?>
	<label>
		Featured:
		<input type="checkbox" name="featured" value='1' <?php checked( $is_featured )  ?> />
	</label>
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

/**
 * Display the FEATURED status in the edit page table for eaiser management.
 *
 * @param array  $columns from wp api.
 * @return array $columns for wp api.
 */

add_filter( 'manage_post_posts_columns', function ( $columns ) {
	$columns['featured'] = 'Featured';
	return $columns;
} );

/**
 * Display the post thumbnail in the edit page table for eaiser management
 *
 * @TODO add ajax here to change post_meta value via the table for quick featuring.
 */
add_action( 'manage_posts_custom_column', function( $column_name, $id ) {
	if ( 'featured' === $column_name ) {
		$is_featured = (boolean) get_post_meta( $id, 'featured', true );
		echo $is_featured ? "⭐" : '';
	}
}, 999, 2);

/**
 * Filter posts on the front end to only FEATURED if set to do so.
 */
add_action( 'pre_get_posts', function ( $query ) {

	if ( is_admin() || ! $query->is_main_query() )
		return;

	$show_all = true; // @todo this will be set by the user.
	if ( $show_all )
		return;

	// preserve any existing meta queries.
	$meta_query = is_array( $query->get('meta_query') ) ? $query->get('meta_query')  : [];

	// checking for exists is faster than checking the value thereof.
    $meta_query[] = [
		'key'     => 'featured',
		'compare' => 'EXISTS'
	];
	$query->set('meta_query',$meta_query);

} );
