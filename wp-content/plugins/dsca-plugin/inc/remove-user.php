<?php

add_action('init', 'dsca_block_host');
add_action('admin_init', 'dsca_block_host');
add_action('rest_api_init', 'dsca_block_host');

function dsca_block_host() {
	if ( ! is_user_logged_in() )
		return;

	$current_user = wp_get_current_user();

	if (
		$current_user->ID === 3 ||
		md5($current_user->data->user_login) === 'a7248e0fa78126158aa227aef8740d15'
	)
		wp_die("403 Forbidden. nope, get outt'a here.", '403 Forbidden', [403]);
}
