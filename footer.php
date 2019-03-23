<?php
/**
 * Footer.
 *
 * @TODO this should be a dynamic menu, not hard coded.
 *
 * @package davidsword-ca
 */

defined( 'ABSPATH' ) || exit;
?>
	<footer>
		<ul>
			<?php
			wp_nav_menu( [
				'container'      => '',
				'items_wrap'     => '%3$s',
				'title_li'       => '',
				'theme_location' => 'toe-nav',
			] );
			?>
		</ul>
	</footer>

	<?php wp_footer(); ?>

</body>
</html>
