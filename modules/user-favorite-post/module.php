<?php

require_once __DIR__ . '/class-user-favorite.php';

add_action('wp_ajax_user_favorite_post', function() {

	$post_id = (int) filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);

	if ($post_id == 0) {
		wp_send_json_error();
	}

	$user_favorite = new User_favorite();



});

