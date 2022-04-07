<?php
/**
 * Single Posts navigation
 *
 * Use to toggle to next/prev post. Supports multiple Custom Post Types.
 *
 * @package davidsword-ca-custom-theme
 */

if ( is_singular() ) : ?>
	<div class='clear navigation'>
		<?php
		if ( false && $is_post_paged ) {
			wp_link_pages( [
				'before' => '<p>Post Pages: &nbsp; ',
			] );
		}
		$nav_post_type = get_post_type_object( get_post_type() );
		next_post_link( '%link', '&laquo; Prev ' . $nav_post_type->labels->singular_name, true );
		previous_post_link( '%link', 'Next '.$nav_post_type->labels->singular_name.' &raquo;', true );
		?>
	</div><!--/navigation-->
<?php endif ?>
