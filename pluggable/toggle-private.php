<?php
add_action( 'wp_ajax_private_toggle', function() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'private_toggle_nonce' ) )
		wp_send_json_error( 'invalid nonce' );
	if ( ! is_user_logged_in() )
		return;
	if ( ! current_user_can( 'manage_options' ) )
		return;

	$post_id = (int) $_POST['post_id'];
	$the_post = get_post( $post_id );
	$new_status = 'private' === $the_post->post_status ? 'publish' : 'private';

	wp_update_post([
		'ID' => $post_id,
		'post_status' => $new_status
	]);

	wp_send_json_success( [ "{$new_status}" ] );
	die();
});

/**
 * Add JS to submit AJAX post on click.
 *
 * @TODO enqueue this properly - or at very least hook it to only show on posts page.
 */
add_action( 'wp_footer', function () {
	if ( ! is_user_logged_in() )
		return;
	if ( ! current_user_can( 'manage_options' ) )
		return;
    ?>

    <script>
		jQuery(document).ready( function($) {
			jQuery('span[data-private]').click( function(e) {
				if ( !confirm('Are you sure?') )
					return;
				//console.dir( e.srcElement.dataset );
				let post_id = e.srcElement.dataset.private;
				var data = {
					action: 'private_toggle',
					post_id,
					"nonce" : <?php echo wp_json_encode( wp_create_nonce( 'private_toggle_nonce' ) ) ?>
				};
				// Post the request to WordPress' AJAX URL.
				$.post( ajaxurl, data, function( response ) {
					if ( response.success ) {
						e.srcElement.textContent = '#'+response.data[0];
					}
					//console.dir( e.srcElement );
					console.dir( '#'+response.data[0] );
				});
			});
		});
    </script>
    <?php
});
