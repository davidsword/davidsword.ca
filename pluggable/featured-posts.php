<?php
/**
 * Featured Posts
 *
 * Add a toggle button to show all posts, or just featured posts.
 * Featured posts are the vital few to show off.
 *
 * Basically the 80/20 rule for WordPress blog, toggle to reveal
 * the remaining 80% of the site.
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
 */
add_action( 'manage_posts_custom_column', function( $column_name, $id ) {
	if ( 'featured' === $column_name ) {
		$is_featured = (boolean) get_post_meta( $id, 'featured', true );
		?>
		<input
			type="checkbox"
			name="featured"
			data-post-id="<?php echo (int) $id  ?>"
			<?php checked( $is_featured )  ?>
		/>
		<?php
	}
}, 999, 2);

/**
 * Listen for feature image toggling.
 */
add_action( 'wp_ajax_feature_toggle', function() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'feature_toggle_nonce' ) ) {
		wp_send_json_error( 'invalid nonce' );
	}

	$post_id = (int) $_POST['post_id'];

	$is_featued = ( isset( $_POST['featured'] ) && '1' === $_POST['featured'] );
	if ( $is_featued ) {
		update_post_meta( $post_id , 'featured', 1 );
	} else {
		delete_post_meta( $post_id, 'featured' );
	}
	wp_send_json_success( [ "update post {$post_id} to {$is_featued}" ] );

	die();
});

/**
 * Add JS to submit AJAX post on click.
 *
 * @TODO enqueue this properly - or at very least hook it to only show on posts page.
 */
add_action( 'admin_footer', function () {
    ?>
    <script>
		jQuery(document).ready( function($) {
			jQuery('input[name="featured"]').click( function(e) {
				console.dir( e.srcElement.dataset );
				let post_id = e.srcElement.dataset.postId;
				// invert the current value for the toggle.
				let featured = jQuery(e.srcElement).is(':checked') ? '1' : '0';
				var data = {
					action: 'feature_toggle',
					post_id,
					featured,
					"nonce" : <?php echo wp_json_encode( wp_create_nonce( 'feature_toggle_nonce' ) ) ?>
				};
				// Post the request to WordPress' AJAX URL.
				$.post( ajaxurl, data, function( response ) {
					if ( response.success ) {
						e.srcElement.dataset.featured = featured;
					}
					console.dir( response );
				});

			});
		});
    </script>
    <?php
});

/**
 * Filter posts on the front end to only FEATURED if set to do so.
 */
add_action( 'pre_get_posts', function ( $query ) {

	// is_home() is here because my main /blog/ is unindexed via the ui, this most likley
	// should be removed for other uses of this.
	if ( is_admin() || is_singular() || is_home() || ! $query->is_main_query() )
		return;

	// 'Featured' content is implied implicitly, 'Show All' is explicit.
	if ( false ) { // turning the toggle off for the time being
		$show_all = isset( $_COOKIE['show_all'] ) && '1' === $_COOKIE['show_all'];
		if ( $show_all )
			return;
	}

	// preserve any existing meta queries.
	$meta_query = is_array( $query->get('meta_query') ) ? $query->get('meta_query')  : [];

	// checking for exists is faster than checking the value thereof.
    $meta_query[] = [
		'key'     => 'featured',
		'compare' => '='
	];
	$meta_query[] = [
		'compare' => 'LIKE',
		'value' => '1'
	];
	$query->set('meta_query',$meta_query);

} );

/**
 * Add toggle form.
 *
 * @TODO hook this properly somewhere instead of relying on a custom template tag (function).
 */
function dsca_toggle_featured_showall() {
	$show_all = isset( $_COOKIE['show_all'] ) && '1' === $_COOKIE['show_all'] ? '1' : '0';
	?>
	<form action='' method='POST'>
		<?php wp_nonce_field( plugin_basename( __FILE__ ), 'show_all_nonce' ); ?>
		<label>
			<input type='radio' name='show_all' value='0' <?php checked( $show_all, '0' ) ?> onchange="this.form.submit()" />
			Show Featured
		</label>
		<br />
		<label>
			<input type='radio' name='show_all' value='1' <?php checked( $show_all, '1' ) ?> onchange="this.form.submit()" />
			Show All
		</label>
	</form>
	<?php
}

/**
 * Process request change.
 *
 * Since a reload is requied for WP_Query refresh, we'll handle the cookie in PHP.
 */
add_action( 'init', function() {
	if ( ! isset( $_POST['show_all'] ) )
		return;
	if ( ! wp_verify_nonce( $_POST['show_all_nonce'], plugin_basename( __FILE__ ) ) )
		return;

	$show_all = ( isset( $_POST['show_all'] ) && '1' === $_POST['show_all'] ) ? '1' : '0';

	$cookie = setcookie(
		'show_all',
		$show_all,
		time() + YEAR_IN_SECONDS
	);

} );

/**
 * Add a count of posts that are featured in Admin Notices.
 *
 * The point of this is the 80/20 rule. The law of the vital few. If I swarm this site with everything
 * I do and treat it like a CMS for my portfolio and thoughts, I will drown out the quality content, that
 * says more about everything I do. The goal is to keep all categories around 20%.
 *
 * The vital few.
 * Less is more.
 * Simple is better.
 *
 * @todo a better spot would be in the `subsubsub` list
 * @todo this should be a cached value
 * @todo query should be optimzied
 * @todo this should specify that cat in the output
 */
add_action( 'admin_notices', function(){
	global $current_screen, $wp_query;

	if ( $current_screen->id !== 'edit-post'  )
		return;

	$get_posts = [
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => '-1',
		'cat' => $wp_query->query['cat'] ?? ''
	];
	$all_posts = count( get_posts( $get_posts ) );

	// now count just featured posts. New query better than looping individually.
	$get_posts['meta_query'] = [[
		'key' => 'featured',
		'compare' => 'EXISTS'
	]];
	$featured_posts = count( get_posts( $get_posts ) );

	$featured = floor( (  $featured_posts /  $all_posts  ) * 100 );
	echo "<div class='notice notice-info'><p>Featured Posts: {$featured}%</p></div>";
} );
