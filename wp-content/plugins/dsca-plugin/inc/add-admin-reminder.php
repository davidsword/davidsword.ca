<?php


add_action( 'admin_notices', function () {
	if ( ! get_option('reminder') )
		return;
    ?>
    <div class="notice notice-info" style='font-size: 1.3em;'>
		<p><strong>Remember: </strong></p>
        <p><?php echo esc_html( get_option('reminder') ); ?></p>
    </div>
    <?php
} );
