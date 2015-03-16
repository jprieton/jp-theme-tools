<?php

/**
 * 
 */
add_action('wp_ajax_nopriv_user_register', function () {

	do_action('pre_user_register');

	$nonce = get_nonce_value();
	$verify_nonce = (bool) wp_verify_nonce($nonce, 'user_register');

	($verify_nonce || is_user_logged_in() || die(0));

	$userdata = array(
			'user_pass' => filter_input(INPUT_POST, 'user_password'),
			'user_login' => filter_input(INPUT_POST, 'user_login'),
			'user_email' => filter_input(INPUT_POST, 'user_login')
	);
	$user_id = wp_insert_user($userdata);

	do_action('post_user_register', $user_id);

	header('Content-Type: application/json');
	is_wp_error($user_id) ? die('false') : die('true');
});
