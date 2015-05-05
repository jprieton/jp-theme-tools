<?php

require_once __DIR__ . '/class-user-favorite.php';
require_once JPTT_PLUGIN_PATH . 'core/class-input.php';

add_action('wp_ajax_user_favorite_post', function() {

	$Input = new \jptt\core\Input();
	$post_id = (int) $Input->get('post_id', array('filter' => FILTER_SANITIZE_NUMBER_INT));

	if ($post_id == 0) {
		wp_send_json_error();
	}

	$user_favorite = new jptt\modules\User_favorite();

	$user_favorite->add_post_to_favorites($post_id);

});

