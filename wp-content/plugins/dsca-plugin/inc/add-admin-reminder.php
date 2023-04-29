<?php


add_action( 'admin_notices', function () {
    ?>
    <div class="notice notice-info">
        <p><?php esc_html( get_option('reminder') ); ?></p>
    </div>
    <?php
} );
