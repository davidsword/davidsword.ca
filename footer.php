<?php
/**
 * Footer.
 *
 * @package davidsword-ca-custom-theme
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

			// @TODO this should be dynamic from db
			?>
			<li>
				Proudly Powered by
				<a href="https://wordpress.org/" target='_Blank'>WordPress</a>,
				<a href="https://jetpack.com/" target='_Blank'>Jetpack</a>, &amp;
				<a href="https://pressable.com/" target='_Blank'>Pressable</a>.
			</li>
			<li>
				<a href='#' style='text-decoration: none !important;' onClick="shade_toggle()">🌗</a>
			</li>
		</ul>
	</footer>

	<?php wp_footer(); ?>

</body>
</html>
