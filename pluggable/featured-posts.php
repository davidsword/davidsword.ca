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
 *
 * @TODO add ajax here to change post_meta value via the table for quick featuring.
 */
add_action( 'manage_posts_custom_column', function( $column_name, $id ) {
	if ( 'featured' === $column_name ) {
		$is_featured = (boolean) get_post_meta( $id, 'featured', true ) ? '1' : '0';
		?>
		<span
			data-featured="<?php echo esc_attr( $is_featured )  ?>"
			data-post-id="<?php echo (int) $id  ?>"
		>⭐</span>
		<?php
	}
}, 999, 2);

add_action( 'admin_footer', function(){
	?>
	<style>
		span[data-featured] {
			padding: 5px;
			font-size:25px
		}
		span[data-featured="0"] {
			opacity: 0.2;
		}
	</style>
	<?php
});

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
 */
add_action( 'admin_footer', function () {
    ?>
    <script>
		jQuery(document).ready( function($) {
			jQuery('[data-featured]').click( function(e) {
				console.dir( e.srcElement.dataset );
				let post_id = e.srcElement.dataset.postId;
				// invert the current value for the toggle.
				let featured = e.srcElement.dataset.featured == '1' ? '0' : '1';
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

function my_plugin_ajax_submit() {
    // some php code that fires from AJAX click of #buildButton
    // wp_mail( 'user@domain.com', 'my_plugin_ajax_submit() fired', time());
    return true;
}

/**
 * Filter posts on the front end to only FEATURED if set to do so.
 */
add_action( 'pre_get_posts', function ( $query ) {

	if ( is_admin() || ! $query->is_main_query() )
		return;

	// 'Featured' content is implicit, 'Show All' is explicit.
	$show_all = isset( $_COOKIE['show_all'] ) && '1' === $_COOKIE['show_all'];
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
