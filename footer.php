<?php
/**
 * Footer
 *
 * @package davidsword-2018
 */

defined( 'ABSPATH' ) || exit;
?>
	<footer>
		<p>
			<a href='mailto:<?php echo get_option('admin_email'); ?>'><?php echo get_option('admin_email'); ?></a>

			&nbsp; | &nbsp;

			Proudly powered by
			<a href='https://wordpress.org' target='_Blank'>WordPress</a>

			&nbsp; | &nbsp;

			Built in 🇨🇦 with
			<a href='https://davidsword.ca/uses/'>all this stuff</a>

			&nbsp; | &nbsp;

			<a href='https://davidsword.ca/🍺/'>🍻</a>
		</p>
	</footer>


	<?php wp_footer(); ?>

</body>
</html>
