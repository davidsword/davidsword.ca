<?php if ( is_singular() ) : ?>
	<div class='clear navigation'>
		<?php
		if ( false && $is_post_paged ) {
			wp_link_pages( array(
				'before' => '<p>Post Pages: &nbsp; ',
			) );
        }
        $post_type = get_post_type_object( get_post_type() );
		next_post_link( '%link', '&laquo; Prev ' . $post_type->labels->singular_name );
		previous_post_link( '%link', 'Next '.$post_type->labels->singular_name.' &raquo;' );
		?>
	</div><!--/navigation-->
<?php endif ?>