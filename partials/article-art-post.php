<article <?php post_class(); ?>>
	<div class='content'>
		<?php dsca_featured_image(); ?>
	</div>

	<header class='post_meta'>

		<a href='<?php echo esc_url( get_permalink() ); ?>' style=''><?php echo get_the_title() ? '"'.esc_html( get_the_title() ).'"' : esc_html( get_the_date() ) ?></a>
		<time class='post_meta__date' style='display:none'>
			<a href='<?php echo esc_url( get_permalink() ); ?>'>
				<?php echo get_the_date(); ?>
			</a>
		</time>
		<span class='post_meta__tags'>
			<?php
			$terms = wp_get_post_terms( get_the_ID(), 'category' );
			foreach ( $terms as $aterm ) {
				if ( $aterm->slug === 'art' )
					continue;
				$alink = get_term_link( $aterm->term_id, 'category' );
				?>
				<a href='<?php echo $alink ? esc_url( $alink ) : ''; ?>'>#<?php echo esc_html( $aterm->slug ); ?></a>
				<?php
			}
			if ( is_sticky() ) {
				echo "<a href='#'>#sticky</a>";
			}
			?>
		</span>
		<?php edit_post_link('#edit-this') ?>
	</header>

</article>
