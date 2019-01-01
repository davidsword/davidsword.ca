<?php
if ( class_exists( 'goodrds' ) ) {
	$paged = get_query_var( 'paged', false );
	if ( 0 !== $paged ) return;
	?>
	<div class="date nomargin">
		<h2>
			<a href="https://www.goodreads.com/"><?php echo date('Ymd'); ?></a>
		</h2>
	</div>
	<div class="ramble">
		<div class="entry">
			<?php echo do_shortcode( '[goodreads]' ); ?>
		</div>
	</div>
	<?php
}
