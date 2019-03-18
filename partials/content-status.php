<?php
/**
 * Content template for posts with the Status format.
 *
 * @package davidsword-ca
 */
?>
<div class='content'>
	<?php
	// Featured image.
	dsca_featured_image();
	the_content();
	?>
</div>