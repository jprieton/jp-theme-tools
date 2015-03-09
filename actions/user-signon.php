<?php

defined('ABSPATH') or die("No script kiddies please!");

/**
 * 
 */
add_action('wp_ajax_nopriv_user_signon', function() {

	$nonce = get_nonce_value();
	$verify_nonce = (bool) wp_verify_nonce($nonce, 'user_signon');

	$submit = array(
			'user_login' => '',
			'user_password' => '',
			'remember' => ''
	);

	if ($verify_nonce) {
		$submit['user_login'] = filter_input(INPUT_POST, 'user_login', FILTER_SANITIZE_STRING)? :
						filter_input(INPUT_GET, 'user_login', FILTER_SANITIZE_STRING);
		$submit['user_password'] = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING)? :
						filter_input(INPUT_GET, 'user_password', FILTER_SANITIZE_STRING);
		$submit['remember'] = filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_STRING)? :
						filter_input(INPUT_GET, 'remember', FILTER_SANITIZE_STRING);
	}

	$user = wp_signon($submit, false);

	do_action('user_signon', $user);
	header('Content-Type: application/json');
	is_wp_error($user) ? die('false') : die('true');
});
